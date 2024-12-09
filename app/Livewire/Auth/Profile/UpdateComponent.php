<?php

namespace App\Livewire\Auth\Profile;

use App\Livewire\BaseComponent;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User as Model;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use App\Traits\ManagesFilesTrait;
use Illuminate\Support\Arr;

class UpdateComponent extends BaseComponent
{
    use WithFileUploads;
    use ManagesFilesTrait;

    public $name;
    public $avatar;
    public $password;
    public $password_confirmation;

    public $title = 'Atualizar';
    public $subtitle = 'Atualize suas informações';
    public $item = null;
    public $filePath = 'avatars';
    public $avatarPath;

    protected function rules()
    {
        return [
            'name'                  => 'required|min:3',
            'avatar'                => 'nullable|image|mimes:jpg,jpeg,png,gif|max:1024',
            'password'              => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|min:6|same:password',
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            ['title' => 'Perfil'],
        ];
    }

    public function update(): void
    {
        $this->authorize('updateProfile', Model::class);

        $data = $this->validate();

        DB::beginTransaction();

        try {
            if (is_null($data['password'])) {
                data_forget($data, 'password');
            }

            $oldAvatarPath = $this->item->avatar;
            $this->item->update(Arr::except($data, ['avatar']));

            if ($this->avatar) {
                $path = $this->uploadFile($this->avatar, $oldAvatarPath, true);
                $this->item->update(['avatar' => $path]);
            }

            DB::commit();

            $this->dispatch('profile-updated');
            $this->success(__('feedback.update_success'), position: 'toast-top');
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error($error->getMessage());
            $this->error(__('feedback.update_error'), position: 'toast-top');
        }
    }

    public function mount()
    {
        $this->authorize('mountProfile', Model::class);

        $this->item = auth()->guard('web')->user();
        $this->fill(collect($this->item)->only(['name', 'password'])->toArray());
        $this->avatarPath = $this->getFileUrl($this->item->avatar);
    }

    #[Title('Perfil')]
    public function render()
    {
        return view('livewire.auth.profile.update-component', [
            'item'          => $this->item,
            'defaultAvatar' => asset('assets/images/no-avatar.png'),
            'breadcrumbs' => $this->getBreadcrumbs(),
        ]);
    }
}
