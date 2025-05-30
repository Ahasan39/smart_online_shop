@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Brand</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="brands.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
		<div class="container-fluid">
            <form action="" id="editBrandForm" name="editBrandForm" action="" method="post">
				<div class="card">
					<div class="card-body">
						<div class="row">
							<div class="col-md-6">
								<div class="mb-3">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ $brand->name }}">
                                    <p></p>
								</div>
                                <p></p>
							</div>
							<div class="col-md-6">
								<div class="mb-3">
									<label for="email">Slug</label>
									<input type="text" readonly name="slug" id="slug" class="form-control" placeholder="Slug" value="{{ $brand->slug }}">
                                    <p></p>
								</div>
							</div>
                            <div class="col-md-6">
								<div class="mb-3">
									<label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ ($brand->status ==1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ ($brand->status ==0) ? 'selected' : '' }} value="0">Block</option>
                                    </select>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="pb-5 pt-3">
					<button type="submit" class="btn btn-primary">Update</button>
					<a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
				</div>
            </form>
		</div>
	    <!-- /.card -->
	</section>
				<!-- /.content -->
@endsection

@section('customJs')
<script>
    $("#editBrandForm").submit(function(event) {
        event.preventDefault();
        var element = $(this);
        $("button[type=submit]").prop('disabled', true);

        $.ajax({
            url: '{{ route("brands.update", $brand->id)}}',
            type: 'post',
            data: element.serializeArray(),
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);

                if (response["status"] == true) {

                 //   window.location.href = "{{ route('categories.index')}}";

                  //  $("#name").removeClass('is-invalid')
                  //      .siblings('p')
                    //    .removeClass('invalid-feedback').html("");

                 //   $("#slug").removeClass('is-invalid')
                  //      .siblings('p')
                   //     .removeClass('invalid-feedback').html("");

                } else {

                    if (response['notFound'] == true) {
                        window.location.href = "{{ route('brands.index')}}";
                    }

                    var errors = response['errors'];
                    if (errors['name']) {
                        $("#name").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['name']);
                    } else {
                        $("#name").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }


                    if (errors['slug']) {
                        $("#slug").addClass('is-invalid')
                            .siblings('p')
                            .addClass('invalid-feedback').html(errors['slug']);
                    } else {
                        $("#slug").removeClass('is-invalid')
                            .siblings('p')
                            .removeClass('invalid-feedback').html("");
                    }

                }

            },
            error: function(jqXHR, exception) {
                console.log("Something went wrong");
            }
        })

    });

    //to sesive slu
    $("#name").change(function() {
        element = $(this);
        $("button[type=submit]").prop('disabled', true);
        $.ajax({
            url: '{{ route("getSlug")}}',
            type: 'get',
            data: {
                title: element.val()
            },
            dataType: 'json',
            success: function(response) {
                $("button[type=submit]").prop('disabled', false);
                if (response["status"] == true) {
                    $("#slug").val(response["slug"]);
                }

            }
        });
    });
</script>
@endsection
