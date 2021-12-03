

 	<option value="1">Single Menu</option>
   @foreach($menuall as $men)
    <option value="{{ $men->id }}" {{ $men->id == $sumber->menu_id ? 'selected' : '' }}> {{ $men->menu }}</option>
  @endforeach 
