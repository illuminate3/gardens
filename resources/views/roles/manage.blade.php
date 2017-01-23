@extends('layouts.vue')

@section('content')

	<div class="container" id="manage-vue">

		<div class="row">
		    <div class="col-lg-12 margin-tb">
		        <div class="pull-left">
		            <h2>Roles</h2>
		        </div>
		        <div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#create-item">
				  Create Role
				</button>
		        </div>
		    </div>
		</div>

		<!-- Item Listing -->
		<table class="table table-bordered">
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th width="200px">Action</th>
			</tr>
			<tr v-for="item in items">
				<td>@{{ item.name }}</td>
				<td>@{{ item.description }}</td>
				<td>	
			      <button class="btn btn-primary" @click.prevent="editItem(item)">Edit</button>
			      <button class="btn btn-danger" @click.prevent="deleteItem(item)">Delete</button>
				</td>
			</tr>
		</table>

		<!-- Pagination -->
		<nav>
	        <ul class="pagination">
	            <li v-if="pagination.current_page > 1">
	                <a href="#" aria-label="Previous"
	                   @click.prevent="changePage(pagination.current_page - 1)">
	                    <span aria-hidden="true">«</span>
	                </a>
	            </li>
	            <li v-for="page in pagesNumber"
	                v-bind:class="[ page == isActived ? 'active' : '']">
	                <a href="#"
	                   @click.prevent="changePage(page)">@{{ page }}</a>
	            </li>
	            <li v-if="pagination.current_page < pagination.last_page">
	                <a href="#" aria-label="Next"
	                   @click.prevent="changePage(pagination.current_page + 1)">
	                    <span aria-hidden="true">»</span>
	                </a>
	            </li>
	        </ul>
	    </nav>

	    <!-- Create Item Modal -->
		<div class="modal fade" id="create-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Create Role</h4>
		      </div>
		      <div class="modal-body">

		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="createItem">

		      			<div class="form-group">
						<label for="name">Name:</label>
						<input type="text" name="name" class="form-control" v-model="newItem.name" />
						<span v-if="formErrors['name']" class="error text-danger">@{{ formErrors['name'] }}</span>
					</div>

					<div class="form-group">
						<label for="title">Description:</label>
						<textarea name="description" class="form-control" v-model="newItem.description"></textarea>
						<span v-if="formErrors['description']" class="error text-danger">@{{ formErrors['description'] }}</span>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>

		      		</form>

		        
		      </div>
		    </div>
		  </div>
		</div>

		<!-- Edit Item Modal -->
		<div class="modal fade" id="edit-item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		        <h4 class="modal-title" id="myModalLabel">Edit Role</h4>
		      </div>
		      <div class="modal-body">

		      		<form method="POST" enctype="multipart/form-data" v-on:submit.prevent="updateItem(fillItem.id)">

		      			<div class="form-group">
						<label for="title">Name:</label>
						<input type="text" name="title" class="form-control" v-model="fillItem.name" />
						<span v-if="formErrorsUpdate['name']" class="error text-danger">@{{ formErrorsUpdate['name'] }}</span>
					</div>

					<div class="form-group">
						<label for="title">Description:</label>
						<textarea name="description" class="form-control" v-model="fillItem.description"></textarea>
						<span v-if="formErrorsUpdate['description']" class="error text-danger">@{{ formErrorsUpdate['description'] }}</span>
					</div>

					<div class="form-group">
						<button type="submit" class="btn btn-success">Submit</button>
					</div>

		      		</form>

		      </div>
		    </div>
		  </div>
		</div>

	</div>

	@endsection