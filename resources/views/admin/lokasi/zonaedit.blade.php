<input type="hidden" name="idbr" id="idbr" value="{{$zona->id}}">
<div class="form-group">
    <label>Nama Zona</label>
    
    <input type="text" id="namaedit" name="namaedit" class="form-control" value="{{$zona->nama}}"  placeholder="nama Zona" >
   
</div>

<div class="form-group">
    <label>Kecamatan</label>
<?php $i = 1;$u = 1; ?>
    @foreach($districtsall as $men)
    <div class="app-checkbox success"> 
        <label><input id="id_districts[<?php echo $u++; ?>]" type="checkbox" name="data[<?php echo $i++; ?>][districts]" value="0{{$men->id}}" <?php Helperss::check_zona($men->id,$zona->id); ?>> {{$men->name}}<span></span></label> 
    </div>
	@endforeach
</div>