<div class="container pt-5 " >
    {{-- The Master doesn't talk, he acts. --}}
    <div class="row">
        <div class=" col-end-8 m-auto ">
            {{-- @dd($isView); --}}

            <form wire:submit="savePost" action=""  > 
                <div class="card shadow ">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-xl-6"> <h5 class="fw-bold">{{ $isView ? 'View' : ($post ? 'Edit' : 'Create') }} Post</h5> </div>
                            <div class="col-xl-6 text-end ">
                                <a wire:navigate href="{{ route('posts') }}" class=" btn btn-primary btn-sm fw-bold rounded ">Back to Post</a>
                            </div>
                        </div>
                    </div>

                    
                    <div class="card-body">

                        {{-- Post Title  --}}
                        <div class="form-group mb-2 ">
                            <label for="title">Title <span class=" text-danger " >*</span></label>
                            <input {{ $isView ? 'disabled' : '' }} type="text" wire:model="title" class="form-control" name="" id="title" placeholder="Post Title" >

                            @error('title')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Post Content  --}}
                        <div class="form-group mb-4 ">
                            <label for="content">Content <span class=" text-danger " >*</span></label>
                            <textarea type="text" wire:model="content" {{ $isView ? 'disabled' : '' }} class="form-control" name="" id="content" placeholder="Post Content" ></textarea>

                            @error('content')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- View Featured Image  --}}
                        @if($post)
                            <label for="">Uploaded Featured Image</label>
                            <div class="my-2">
                                <img src=" {{ Storage::url($post->featured_image) }} " class=" img-fluid " width="250px" alt="img">
                            </div>
                        @endif

                        {{-- Post Featured Image --}}
                        @if(!$isView)
                            <div class="form-group mb-2 ">
                                <label for="featuredImage">Featured Image <span class=" text-danger " >*</span></label>
                                <input type="file" wire:model="featuredImage"  class="form-control" name="" id="featuredImage" >

                                {{-- Preview image  --}}
                                @if($featuredImage)
                                    <div class="my2">
                                        <img src="{{ $featuredImage->temporaryUrl() }}" class="img-fluid" width="200px" alt="">
                                    </div>
                                @endif
                                @error('featuredImage')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif 

                    </div>

                    @if(!$isView)
                        <div class="card-footer">
                            <div class="form-group mb-2 ">
                                <button type="submit" class=" btn btn-success " > {{ $post ? 'Update':'Save' }} </button>
                            </div>
                        </div>
                    @endif

                </div>
            </form>

        </div>
    </div>
</div>


