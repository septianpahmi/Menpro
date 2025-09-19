@foreach($getRecord()->results->flatMap->files as $file)
    <a href="{{ Storage::url($file->file_path) }}" 
       target="_blank"
       class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 mr-1">Preview
    </a>
@endforeach
