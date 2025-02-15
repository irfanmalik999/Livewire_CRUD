<?php

namespace App\Livewire;

use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\UserPosts;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Title;

class PostList extends Component
{

    use WithPagination, WithoutUrlPagination;

    #[Title('Livewire 3 CRUD - Post Listing')]

    // Searching Functionality
    public $searchTerm = null;
    public $activePageNumber = 1;

    public $sortColumn = 'id';
    public $sortOrder = 'asc';

    public function sortBy($columnName){
        if($this->sortColumn === $columnName){
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $columnName;
            $this->sortOrder = 'asc';
        }
    }

    // public $userPosts;

    public function fetchPosts(){
        return UserPosts::where('title', 'like', '%' . $this->searchTerm .  '%')
        ->orWhere('content', 'like', '%' . $this->searchTerm .  '%')
        ->orderBy($this->sortColumn, $this->sortOrder)->paginate(5);
    }
  
    public function render()
    {
        $userPosts = $this->fetchPosts();
        // dd($this->userPosts);

        return view('livewire.post-list', compact('userPosts'));
    }
 
    // Using Route Model Binding to Delete Post
    public function deletePost(UserPosts $post){
        if($post){
            #Delete Featured Image
           if(Storage::exists($post->featured_image)) {
                Storage::delete($post->featured_image);
           }
            $deleteResponse =  $post->delete();
            if($deleteResponse){
                session()->flash('success', 'Post deleted Successfully!');
            } else {
                session()->flash('error', 'unable to delete User Post. Please try again!');
            }
        }else {
            session()->flash('error', 'User Post not Found. Please try again!');
        }

        // return $this->redirect('/posts', navigate:true);

        $posts = $this->fetchPosts();
        if($posts->isEmpty() && $this->activePageNumber>1){
             // Redirect to the Active Page - 1 ( Previous Page )
            $this->gotoPage($this->activePageNumber - 1);
        } else {
            // Redirect to the Active Page 
            $this->gotoPage($this->activePageNumber);
        }

    }

    // Function: Track the active page from pagination 
    public function updatingPage($pageNumber){
        $this->activePageNumber = $pageNumber;
    }

}
