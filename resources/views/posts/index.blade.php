@extends('layouts.nav')
<link href="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.css" rel="stylesheet">

@section('content')
    <div class="py-10 post_table_parent  text-white">
        <p style="display:none" class=" message_text_show text-center text-xl text-green-700">
            {{ session()->get('status') }}
        </p>
        <div class="mb-10 link_heading flex justify-between items-center">
            <h1 class=" text-4xl font-bold">Posts Table</h1>
            <a class=" bg-blue-500 px-5 py-3 transition-all hover:bg-blue-400 " href="{{ route('posts.create') }}">Post
                Create</a>
        </div>
        <table id="postTable" class=" !w-full text-white !border-white">
            <thead class="bg-orange-600">
                <tr>
                    <th>id</th>
                    <th>Name</th>
                    <th>Content</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
            <tbody class=""></tbody>
            </thead>
        </table>
    </div>
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.8/r-2.5.0/datatables.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {

            var postTable = $("#postTable").DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('posts.index') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    }, {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'content',
                        name: 'content'
                    }, {
                        data: 'category',
                        name: 'category',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    },
                ],
            });
            $(document).on("click", ".delete_post", function(e) {
                e.preventDefault();
                if (confirm('Are you sure to delete this post')) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $("meta[name=csrf-token]").attr("content"),
                        },
                        type: "delete",
                        url: $(this).attr("delete-data"),
                        success: function(response) {
                            if (response.status) {
                                $(".message_text_show").text("Post deleted.").fadeIn().delay(
                                    3000).fadeOut();
                                postTable.draw();
                            }
                        },
                    });
                }
            });
        });
    </script>
@endsection
