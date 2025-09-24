<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->get('path', '');
        $type = $request->get('type', 'image'); // image, document, etc
        
        $basePath = public_path('img/uploads');
        $fullPath = $basePath . '/' . $path;
        
        // Pastikan folder ada
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }
        
        $items = [];
        
        if (File::exists($fullPath)) {
            $files = File::allFiles($fullPath);
            $directories = File::directories($fullPath);
            
            // Add directories
            foreach ($directories as $dir) {
                $dirName = basename($dir);
                $items[] = [
                    'name' => $dirName,
                    'type' => 'folder',
                    'path' => $path ? $path . '/' . $dirName : $dirName,
                    'size' => null,
                    'modified' => File::lastModified($dir)
                ];
            }
            
            // Add files
            foreach ($files as $file) {
                $relativePath = str_replace($basePath . '/', '', $file->getPathname());
                $extension = $file->getExtension();
                
                // Filter by type if specified
                if ($type === 'image' && !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    continue;
                }
                
                $items[] = [
                    'name' => $file->getFilename(),
                    'type' => 'file',
                    'path' => $relativePath,
                    'url' => asset('img/uploads/' . $relativePath),
                    'size' => $file->getSize(),
                    'extension' => $extension,
                    'modified' => $file->getMTime(),
                    'is_image' => in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp'])
                ];
            }
        }
        
        // Sort: folders first, then files
        usort($items, function($a, $b) {
            if ($a['type'] !== $b['type']) {
                return $a['type'] === 'folder' ? -1 : 1;
            }
            return strcasecmp($a['name'], $b['name']);
        });
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'items' => $items,
                'current_path' => $path
            ]);
        }
        
        return view('admin.file-manager.index', compact('items', 'path'));
    }
    
    public function upload(Request $request)
    {
        $request->validate([
            'files.*' => 'required|image|max:5120', // 5MB
            'path' => 'nullable|string'
        ]);
        
        $path = $request->get('path', '');
        $uploadPath = public_path('img/uploads/' . $path);
        
        // Pastikan folder ada
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0755, true);
        }
        
        $uploadedFiles = [];
        
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '_' . time() . '.' . $extension;
                
                $file->move($uploadPath, $fileName);
                
                $relativePath = $path ? $path . '/' . $fileName : $fileName;
                
                $uploadedFiles[] = [
                    'name' => $fileName,
                    'original_name' => $originalName,
                    'path' => $relativePath,
                    'url' => asset('img/uploads/' . $relativePath),
                    'size' => filesize($uploadPath . '/' . $fileName)
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' file berhasil diupload',
            'files' => $uploadedFiles
        ]);
    }
    
    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'path' => 'nullable|string'
        ]);
        
        $folderName = Str::slug($request->name);
        $path = $request->get('path', '');
        $fullPath = public_path('img/uploads/' . ($path ? $path . '/' : '') . $folderName);
        
        if (File::exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Folder sudah ada'
            ]);
        }
        
        File::makeDirectory($fullPath, 0755, true);
        
        return response()->json([
            'success' => true,
            'message' => 'Folder berhasil dibuat',
            'folder' => [
                'name' => $folderName,
                'path' => $path ? $path . '/' . $folderName : $folderName
            ]
        ]);
    }
    
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);
        
        $fullPath = public_path('img/uploads/' . $request->path);
        
        if (!File::exists($fullPath)) {
            return response()->json([
                'success' => false,
                'message' => 'File atau folder tidak ditemukan'
            ]);
        }
        
        if (File::isDirectory($fullPath)) {
            File::deleteDirectory($fullPath);
            $message = 'Folder berhasil dihapus';
        } else {
            File::delete($fullPath);
            $message = 'File berhasil dihapus';
        }
        
        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }
}