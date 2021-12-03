   @foreach($roleeall as $men)
    <option value="{{ $men->id }}" {{ $men->id == $sumber->role_id ? 'selected' : '' }}> {{ $men->role }}</option>
  @endforeach 
