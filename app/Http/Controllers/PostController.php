<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function index(Request $request)
    {
        $search = $request->input('search'); // Get the search query
    
        if (Auth::user()->is_admin) {
            // Admin user sees all posts
            $posts = Post::where(function($query) use ($search) {
                if ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                }
            })->paginate(10);
        } else {
            // Regular user sees only their own posts
            $posts = Post::where('user_id', Auth::id())->where(function($query) use ($search) {
                if ($search) {
                    $query->where('title', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                }
            })->paginate(10);
        }
    
        return view('posts.index', compact('posts', 'search'));
    }
    

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);
    
        // Create the post without the image first
        $data = $request->only('title', 'description');
        $data['user_id'] = Auth::id();
        $post = Post::create($data); // Store the post to get the ID
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Create a filename based on the post ID
            $filename = 'post_' . $post->id . '.' . $image->getClientOriginalExtension();
            // Store the image with the new filename
            $post->image = $image->storeAs('images', $filename, 'public'); // Storing in public disk
            $post->save(); // Update the post record with the image path
        }
    
        return redirect()->route('home');
    }
    



    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('title', 'description');


        if ($request->hasFile('image')) {

            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }

            $image = $request->file('image');
            $filename = 'post_' . $post->id . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('images', $filename, 'public'); // Store in public disk
        }

        // Update the post with the new data
        $post->update($data);

        return redirect()->route('home');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        // Check if the post has an image and delete it
        if ($post->image) {
            $imagePath = storage_path('app/public/' . $post->image); // Adjust the path based on your storage setup
            if (file_exists($imagePath)) {
                unlink($imagePath); // Delete the image file
            }
        }

        $post->delete(); // Delete the post record
        return redirect()->route('home')->with('success', 'Post deleted successfully.');
    }


    public function show(Post $post)
    {
        $this->authorize('view', $post);
        return view('posts.show', compact('post'));
    }
}
