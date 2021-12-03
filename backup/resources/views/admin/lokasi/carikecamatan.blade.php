

 	<option value="{{ $sumber->district_id }}">{{ $gampong->name }}</option>
   @foreach($gampongall as $men)
    <option value="{{ $men->id }}" {{ $men->id == $sumber->district_id ? 'selected' : '' }}> {{ $men->name }}</option>
  @endforeach 
