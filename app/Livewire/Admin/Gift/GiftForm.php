<?php

namespace App\Livewire\Admin\Gift;

use App\Models\Gift;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.dashboard', ['title' => 'Gift Dashboard'])]
class GiftForm extends Component
{
    use WithFileUploads;

    public ?int $giftId = null;

    public string $name = '';

    public $coins = null;

    public string $animation_type = 'gif';

    public $animation_file = null;

    public string $cdn_url = '';

    public bool $is_active = true;

    public bool $isEdit = false;

    public function mount($id = null): void
    {
        if ($id) {
            $gift = Gift::findOrFail($id);
            $this->isEdit = true;
            $this->giftId = $gift->id;
            $this->name = $gift->name;
            $this->coins = $gift->coins;
            $this->animation_type = $gift->animation_type;
            $this->cdn_url = $gift->cdn_url ?? '';
            $this->is_active = $gift->is_active;
        }
    }

    protected function rules(): array
    {
        $fileRules = ['nullable', 'file', 'max:10240'];

        if ($this->animation_type === 'gif') {
            $fileRules[] = 'extensions:gif';
        } elseif ($this->animation_type === 'lottie') {
            $fileRules[] = 'extensions:json';
        }

        // SMART LOGIC: File is required only if CDN URL is empty
        if (empty($this->cdn_url) && (! $this->isEdit || $this->animation_file)) {
            $fileRules = array_diff($fileRules, ['nullable']);
            $fileRules[] = 'required';
        }

        return [
            'name' => ['required', 'string', 'max:255'],
            'coins' => ['required', 'integer', 'min:1'],
            'animation_type' => ['required', Rule::in(['gif', 'lottie'])],
            'animation_file' => $fileRules,
            'cdn_url' => ['nullable', 'url', 'max:2048'],
            'is_active' => ['boolean'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Gift name is required.',
            'coins.required' => 'Coin price is required.',
            'animation_file.required' => 'Please provide either a CDN URL or upload a file.',
            'animation_file.extensions' => $this->animation_type === 'gif'
                ? 'Please upload a valid GIF file.'
                : 'Please upload a valid Lottie JSON file.',
        ];
    }

    public function updatedAnimationType(): void
    {
        $this->resetValidation('animation_file');
        $this->animation_file = null;
    }

    public function saveGift()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            $gift = $this->isEdit ? Gift::findOrFail($this->giftId) : new Gift;

            $gift->name = $this->name;
            $gift->coins = (int) $this->coins;
            $gift->animation_type = $this->animation_type;
            $gift->is_active = $this->is_active;

            // SMART LOGIC: CDN takes priority. If cdn_url is filled, use it.
            if (! empty($this->cdn_url)) {
                if ($gift->animation_path) {
                    Storage::disk('public')->delete($gift->animation_path);
                }
                $gift->animation_path = null;
                $gift->cdn_url = $this->cdn_url;
            }
            // If no CDN, but we have a file upload
            elseif ($this->animation_file) {
                if ($gift->animation_path) {
                    Storage::disk('public')->delete($gift->animation_path);
                }

                $folder = $this->animation_type === 'gif' ? 'uploads/gifts/gif' : 'uploads/gifts/lottie';
                $gift->animation_path = $this->animation_file->store($folder, 'public');
                $gift->cdn_url = null;
            }

            $gift->save();
            DB::commit();

            session()->flash('success', $this->isEdit ? 'Gift updated successfully.' : 'Gift created successfully.');

            if (! $this->isEdit) {
                $this->resetForm();
            }
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            session()->flash('error', 'Something went wrong while saving.');
        }
        $this->dispatch('scroll-to-top');
    }

    public function deleteGift(int $id): void
    {
        try {
            $gift = Gift::findOrFail($id);
            if ($gift->animation_path) {
                Storage::disk('public')->delete($gift->animation_path);
            }
            $gift->delete();
            session()->flash('success', 'Gift deleted successfully.');
            if ($this->giftId === $id) {
                $this->resetForm();
            }
        } catch (\Throwable $e) {
            report($e);
            session()->flash('error', 'Unable to delete the gift.');
        }
    }

    public function resetForm(): void
    {
        $this->reset(['giftId', 'name', 'coins', 'animation_file', 'cdn_url']);
        $this->animation_type = 'gif';
        $this->is_active = true;
        $this->isEdit = false;
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.admin.gift.gift-form');
    }
}
