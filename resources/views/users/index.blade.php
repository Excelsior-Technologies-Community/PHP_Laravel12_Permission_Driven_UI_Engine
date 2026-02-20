<h2>User Management</h2>

<table border="1">
@foreach($users as $user)
<tr>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>
<form method="POST" action="/users/{{ $user->id }}/role">
@csrf
<select name="role">
@foreach($roles as $role)
<option value="{{ $role->name }}"
 {{ $user->hasRole($role->name) ? 'selected':'' }}>
 {{ $role->name }}
</option>
@endforeach
</select>
<button>Update</button>
</form>
</td>
</tr>
@endforeach
</table>