<?php

namespace App\Livewire;

use App\Models\UserPosts;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;


class PostForm extends Component
{

    use WithFileUploads;

    #[Title('Livewire 3 CRUD - Manage Posts ')]


    public $post = null;
    public $isView = false;

    #[Validate('required', message: 'User Post title is required')]
    #[Validate('min:3', message: 'User Post title must be 3 chars long')]
    #[Validate('max:100', message: 'User Post title must not be more than 100 chars long')]
    public $title;

    #[Validate('required', message: 'User Post Content is required')]
    #[Validate('min:10', message: 'User Post Content must be 3 chars long')]
    public $content;

    public $featuredImage;

// here I am using Route Model Binding 🏳️
    public function mount(UserPosts $post){
        // dd($post);
        $this->isView = request()->routeIs('posts.view');
        if($post->id){
            $this->post = $post;
            $this->title = $post->title;
            $this->content = $post->content;
        }

    }

    public function savePost(){
        // dd($this->featuredImage);
        $this->validate();

        $rules = [
            'featuredImage' => $this->post && $this->post->featured_image
                ? 'nullable|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:5120'
                : 'required|image|mimes:jpg,jpeg,png,svg,bmp,webp,gif|max:5120',
        ];
        
        $messages = [
            'featuredImage.required' => 'User Featured Image is required',
            'featuredImage.image' => 'Featured Image must be a valid image',
            'featuredImage.mimes' => 'User Featured Image accepts only jpg, jpeg, png, svg, bmp, webp, and gif',
            'featuredImage.max' => 'User Featured Image must not be larger than 5MB',
        ];
        
        $this->validate($rules, $messages);
        

        $imagePath=null;
        
        if($this->featuredImage){
            $imageName = time().'.'.$this->featuredImage->extension();
            $imagePath = $this->featuredImage->storeAs('public/uploads', $imageName);
        }

        
        if($this->post){
            // This is for the the Updated Functionality 

            $this->post->title = $this->title;
            $this->post->content = $this->content;

            if($imagePath){
                $this->post->featured_image = $imagePath;
            }
            $updatedPost = $this->post->save();

            if($updatedPost){
                session()->flash('success', 'UserPost has been Updated successfully!');
            } 
            else{
                session()->flash('error', 'unable to Update UserPost please try again');
            }

        }
        else{
            $userPost = UserPosts::create([
                'title'=> $this->title,
                'content'=> $this->content,
                'featured_image'=> $imagePath,
            ]);

            if($userPost){
                session()->flash('success', 'UserPost has been published successfully!');
            } 
            else{
                session()->flash('error', 'unable to create UserPost please try again');
            }
        }
  
        return $this->redirect('/posts', navigate:true);

    }
 
    public function render()
    {
        return view('livewire.post-form');
    }
}
