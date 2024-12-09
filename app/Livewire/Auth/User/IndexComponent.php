<?php

namespace App\Livewire\Auth\User;

use App\Livewire\BaseComponent;
use App\Models\Auth\User as Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\DB;

class IndexComponent extends BaseComponent
{
    use WithPagination;

    public bool $modal = false;
    public ?string $modalText = null;
    public ?string $selectedItemId = null;
    public string $search = '';
    public array $sortBy = ['column' => 'name', 'direction' => 'asc'];
    public string $action;
    public int $perPage = 10;
    public $title = 'Usuários';
    public $subtitle = 'Gerencie os usuários do sistema';

    public function getHeaders(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nome', 'class' => 'w-64 text-black'],
            ['key' => 'email', 'label' => 'E-mail', 'class' => 'w-64 text-black'],
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            ['title' => 'Usuários'],
        ];
    }

    #[Computed]
    public function items(): LengthAwarePaginator
    {
        $this->authorize('list', Model::class);
        $query = Model::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortBy['column'], $this->sortBy['direction']);

        return $query->paginate($this->perPage);
    }

    #[On('delete-user')]
    public function delete(): void
    {
        $this->authorize(__FUNCTION__, Model::class);

        DB::beginTransaction();

        try {
            if (Auth::guard('web')->user()->id === $this->selectedItemId) {
                $this->error(__('validation.delete_myself'), position: 'toast-top');

                return;
            }

            $item = Model::findOrFail($this->selectedItemId);
            $item->delete();

            DB::commit();

            $this->selectedItemId = null;
            $this->success(__('feedback.delete_success'), position: 'toast-top');
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error($error->getMessage());
            $this->error(__('feedback.delete_error'), position: 'toast-top');
        }
    }

    #[On('search-updated')]
    public function searchUpdated(string $search): void
    {
        $this->search = $search;
    }

    public function mount(): void
    {
        $this->authorize(__FUNCTION__, Model::class);
    }

    public function confirmAction(string $identification, string $ItemId)
    {
        $this->selectedItemId = $ItemId;
        $this->modalText =  __('action.confirm_delete', ['type' => 'o usuário', 'identification' => $identification]);
        $this->action = 'delete-user';
        $this->modal = true;
        $this->dispatch('action-required', [
            'modal'          => $this->modal,
            'modalText'      => $this->modalText,
            'action'         => $this->action,
        ]);
    }

    #[Title('Usuários')]
    public function render(): View
    {
        $noContent = $this->items()->isEmpty();

        return view('livewire.auth.user.index', [
            'headers' => $this->getHeaders(),
            'breadcrumbs' => $this->getBreadcrumbs(),
            'noContent'   => $noContent,
            'searching'   => !$noContent || ($noContent && $this->search),
            'createRoute' => route('users.create'),
        ]);
    }
}
