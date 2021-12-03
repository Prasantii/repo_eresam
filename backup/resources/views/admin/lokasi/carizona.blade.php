

 	<option value="{{ $sumber->id_districts }}">{{ $districts->name }}</option>
   @foreach($districtsall as $men)
    <option value="{{ $men->id }}" {{ $men->id == $sumber->id_districts ? 'selected' : '' }}> {{ $men->name }}</option>
  @endforeach 
