

 
   @foreach($gampongall as $men)
    <option value="0{{ $men->id }}" {{ $men->id == $sumber->district_id ? 'selected' : '' }}> {{ $men->name }}</option>
  @endforeach 
