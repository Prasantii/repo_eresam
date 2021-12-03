

  
    {{-- <option value="{{  }}" hidden> {{ $menuuu->menu }}</option> --}}
 
   @foreach($menuall as $men)
    <option value="{{ $men->id }}" {{ $men->id == $sumber->id_titile_menu ? 'selected' : '' }}> {{ $men->menu }}</option>
  @endforeach 
