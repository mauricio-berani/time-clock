<?php

namespace App\Livewire\Auth\User;

use App\Enums\Auth\Roles;
use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Auth\User as Model;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;

class CreateComponent extends BaseComponent
{
    public $name;
    public $email;
    public $document;
    public $job_title;
    public $birthday;
    public $password;
    public $password_confirmation;
    public $user_role;

    public $zip_code;
    public $state;
    public $city;
    public $neighborhood;
    public $street;
    public $number;
    public $complement;

    public $title = 'Cadastrar';
    public $subtitle = 'Cadastre um novo usuário';
    public $itemId = null;
    public $item = null;
    public $roleOptions;

    protected function rules(): array
    {
        return [
            'name'                  => 'required|min:3',
            'email'                 => 'required|email|unique:users,email',
            'document'              => 'required|cpf|unique:users,document',
            'job_title'             => 'nullable',
            'birthday'              => 'nullable',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6|same:password',
            'user_role'             => ['required', new Enum(Roles::class)],

            'zip_code'              => 'required|size:8',
            'state'                 => 'required|size:2',
            'city'                  => 'required|string|max:100',
            'neighborhood'          => 'required|string|max:100',
            'street'                => 'required|string|max:255',
            'number'                => 'required|string|max:20',
            'complement'            => 'nullable|string|max:255',
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            ['title' => 'Usuários', 'link' => route('users.index')],
            ['title' => 'Cadastrar'],
        ];
    }

    public function create(): void
    {
        $this->authorize(__FUNCTION__, Model::class);

        $data = $this->validate();

        DB::beginTransaction();

        try {
            $role = $data['user_role'];
            data_forget($data, 'user_role');
            $item = Model::create($data);
            $item->assignRole($role);
            $this->setAddress($item, $data);

            DB::commit();

            $this->success(
                title: __('feedback.create_success'),
                position: 'toast-top',
                timeout: 3000,
                redirectTo: route('users.update', ['user' => $item])
            );
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error($error->getMessage());
            $this->error(__('feedback.create_error'), position: 'toast-top');
        }
    }

    public function setAddress(Model $item, array $data): void
    {
        $item->address()->create(
            [
                'zip_code'     => $data['zip_code'],
                'state'        => $data['state'],
                'city'         => $data['city'],
                'neighborhood' => $data['neighborhood'],
                'street'       => $data['street'],
                'number'       => $data['number'],
                'complement'   => $data['complement'],
            ]
        );
    }

    public function fetchAddress()
    {

        if (strlen($this->zip_code) < 8) {
            return;
        }

        try {
            $response = Http::get("https://viacep.com.br/ws/{$this->zip_code}/json/");

            if ($response->successful() && !isset($response['erro'])) {
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->street = $response['logradouro'] ?? '';
                $this->complement = $response['complemento'] ?? '';
            } else {
                $this->resetAddressFields();
                $this->addError('zip_code', 'CEP não encontrado ou inválido.');
            }
        } catch (\Exception $e) {
            $this->resetAddressFields();
            $this->addError('zip_code', 'Erro ao buscar o CEP.');
        }
    }

    private function resetAddressFields()
    {
        $this->state = '';
        $this->city = '';
        $this->neighborhood = '';
        $this->street = '';
        $this->complement = '';
    }

    public function mount(): void
    {
        $this->authorize('create', Model::class);
        $this->roleOptions = Roles::options();
    }

    #[Title('Usuários')]
    public function render(): View
    {
        return view('livewire.auth.user.form', [
            'item' => null,
            'roleOptions' => $this->roleOptions,
            'breadcrumbs' => $this->getBreadcrumbs(),
        ]);
    }
}
