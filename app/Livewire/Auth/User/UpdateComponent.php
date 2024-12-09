<?php

namespace App\Livewire\Auth\User;

use App\Enums\Auth\Roles;
use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Auth\User as Model;
use App\Models\Auth\User;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;

class UpdateComponent extends BaseComponent
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

    public $title = 'Atualizar';
    public $subtitle = 'Atualize um usuário';
    public $itemId = null;
    public $item = null;
    public $roleOptions;
    public User $loggedUser;

    protected function rules(): array
    {
        return [
            'name'                  => 'required|min:3',
            'email'                 => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->itemId)
            ],
            'document'              => 'required|cpf',
            'job_title'             => 'nullable',
            'birthday'              => 'nullable',
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6|same:password',
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
            ['title' => 'Atualizar'],
        ];
    }

    public function update(): void
    {
        $this->authorize(__FUNCTION__, Model::class);

        $data = $this->validate();

        DB::beginTransaction();

        try {
            $role = $data['user_role'];
            data_forget($data, 'user_role');
            $this->item->update($data);
            $this->item->syncRoles([$role]);
            $this->setAddress($data);

            DB::commit();

            $this->success(__('feedback.update_success'), position: 'toast-top');
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error($error->getMessage());
            $this->error(__('feedback.update_error'), position: 'toast-top');
        }
    }

    public function setAddress(array $data)
    {
        $this->item->address()->updateOrCreate(
            ['user_id' => $this->item->id],
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

    public function loadAddress()
    {
        if ($this->item->address) {
            $this->zip_code = $this->item->address->zip_code;
            $this->state = $this->item->address->state;
            $this->city = $this->item->address->city;
            $this->neighborhood = $this->item->address->neighborhood;
            $this->street = $this->item->address->street;
            $this->number = $this->item->address->number;
            $this->complement = $this->item->address->complement;
        }
    }

    public function mount(Model $user): void
    {
        $this->authorize('update', Model::class);
        $this->itemId = $user->id;
        $this->item = $user->load('address');
        $this->loadAddress();
        $this->fill($this->item->toArray());
        $this->user_role = $this->item->roles->first()?->name;
        $this->roleOptions = Roles::options();
        $this->loggedUser = auth()->guard('web')->user();
    }

    #[Title('Usuários')]
    public function render(): View
    {
        return view('livewire.auth.user.form', [
            'item' => $this->item,
            'timeRecords' => $this->loggedUser->isAdmin() ?
                $this->item->timeRecords()->orderBy('recorded_at', 'desc')->paginate(10) :
                null,
            'roleOptions' => $this->roleOptions,
            'breadcrumbs' => $this->getBreadcrumbs(),
        ]);
    }
}
