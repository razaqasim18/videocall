<?php

namespace App\Livewire\Admin\SubscriptionCategory;

use Livewire\Component;
use App\Models\SubscriptionCategory as ModelsCategory;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.dashboard')]
class SubscriptionCategory extends Component
{
    use WithPagination;

    public string $search = '';
    public string $categoryName = '';
    public ?int $selectedCategoryId = null;
    public bool $isActive = true;

    // Modal Visibility States
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showDeleteModal = false; // Added for consistency
    

    public ?int $categoryToDelete = null; // Cleaned name from categorydToDelete

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openAddModal()
    {
        $this->resetErrorBag();
        $this->categoryName = '';
        $this->showAddModal = true;
    }

    public function openEditModal(int $id)
    {
        $this->resetErrorBag();
        $category = ModelsCategory::findOrFail($id);
        $this->selectedCategoryId = $id;
        $this->categoryName = $category->name;
        $this->showEditModal = true;
    }

    public function closeModals()
    {
        $this->showAddModal = false;
        $this->showEditModal = false;
        $this->showDeleteModal = false; // Now closes the delete modal too
        $this->selectedCategoryId = null;
        $this->categoryToDelete = null;
    }

    public function saveCategory()
    {
        $this->validate([
            'categoryName' => 'required|min:2|max:255',
        ]);

        ModelsCategory::create([
            'name' => $this->categoryName,
            'is_active' => $this->isActive,
        ]);

        session()->flash('success', 'Category created successfully!');
        $this->closeModals();
    }

    public function updateCategory()
    {
        $this->validate([
            'categoryName' => 'required|min:2|max:255',
        ]);

        $category = ModelsCategory::findOrFail($this->selectedCategoryId);
        $category->update([
            'name' => $this->categoryName,
            'is_active' => $this->isActive,
        ]);

        session()->flash('success', 'Category updated successfully!');
        $this->closeModals();
    }

    public function confirmDelete(int $id)
    {
        $this->categoryToDelete = $id;
        $this->showDeleteModal = true; // Set boolean to true instead of dispatching event
    }

    public function deleteCategory()
    {
        if ($this->categoryToDelete) {
            ModelsCategory::destroy($this->categoryToDelete);
            session()->flash('success', 'Category deleted successfully!');
        }

        $this->closeModals(); // Use the centralized close method
        $this->dispatch('scroll-to-top');
    }

    public function paginationView()
    {
        return 'vendor.pagination.tailwind';
    }

    public function render()
    {
        return view('livewire.admin.subscriptioncategory.subscriptioncategory', [
            'categories' => ModelsCategory::where('name', 'like', '%' . $this->search . '%')
                ->orderBy('id', 'desc')
                ->paginate(10)
                ->withPath(route('admin.subscription.category'))
        ]);
    }
}
