<div class="col-md-3 col-md-push-9">
  <h3>Опции</h3>
  @if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
  <div class="form-group">
    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#userFormModal">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новый сотрудник
    </button>
  </div>
  @endif
</div>
  <div class="col-md-9 col-md-pull-3">
   <div class="table-responsive">
   <table class="table table-bordered">
   <thead>
     <tr>
	   <th>Имя</th>
	   <th>Должность</th>
	   <th>Телефон</th>
	   <th>email</th>
	 </tr>
   </thead>
   <tbody>
      <tr ng-repeat="subordinate in subordinates">
	  <td onClick="markRow(this)">

      <a href="#" ng-click="editUserClickEvent(subordinate.id)"><% subordinate.name %></a>
      <button class="btn btn-danger btn-xs pull-right" ng-click="deleteUserClickEvent(subordinate.id)" ng-init="count=0">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
      </button>
    </td>
	  <td><a href="#"><% subordinate.role.name %></a></td>
	  <td><a href="#"><% subordinate.phone %></a></td>
	  <td><a href="#"><% subordinate.email %></a></td>
	  </tr>
  </tbody>
  </table>
  </div>
  </div>
  <!-- Modal -->
		<div class="modal fade" id="userFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Новый сотрудник</h4>
			  </div>
			  <form id="userForm" method="POST" action="{{url('users')}}/saveUser">
			    <div class="modal-body">
				  @include('errors.errorlist')
				  {!! csrf_field() !!}
				<div class="form-group">
				  {!! Form::label('name', 'Имя: ') !!}
				  {!! Form::text('name', null, ['class'=>'form-control']) !!}
				</div>
				<div class="form-group">
				  {!! Form::label('phone', 'Телефон: ') !!}
				  {!! Form::text('phone', null, ['class'=>'form-control']) !!}
				</div>

				<div class="form-group">
				  {!! Form::label('email', 'Email: ') !!}
				  {!! Form::email('email', null, ['class'=>'form-control']) !!}
				</div>
				<input name="wash_id" type="hidden" id="wash_id" value="{{$wash_id}}" />
				<div class="form-group">
				  {!! Form::label('role_id', 'Должность: ') !!}
				  <select name="role_id" class="form-control">
					@foreach($roles as $item)
						<option value="{{$item->id}}">{{$item->name}}</option>
					@endforeach
				  </select>
				</div>
				<div class="form-group">
				  {!! Form::label('password', 'Пароль: ') !!}
				  {!! Form::password('password', ['class'=>'form-control']) !!}
				</div>

        <div class="form-group">
          {!! Form::label('password_confirmation', 'Подтверждение: ') !!}
          {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
          {!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
        </div>
			  </form>
			</div>
		  </div>
		  </div>
		</div>
  <!-- END modal -->
