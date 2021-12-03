<table id="sponsor" class="table table-striped table-bordered"  style="width: max-content 100%;" >
    <thead>
        <tr>
            <th>NO</th>
            <th>MENU</th>
            <th>ACCESS</th>
            
        </tr>
    </thead>  
    <tbody>
    	<?php $i = 1; ?>
        @foreach($menuuu as $m)
            <tr>
                <th scope="row"><?php echo $i ?></th>
                <td><?php if($m->id == 1){ echo "Single Menu"; }else{ echo $m->menu; }  ?></td>
                <td>
                    <div class="form-check">
                    	<input type="checkbox" class="check-input" <?php Helperss::check_access($role->id, $m->id); ?> data-role="<?php echo $role->id ?>" data-menu="<?php echo $m->id ?>">
                    </div>

                </td>
            </tr>
            <?php $i++; ?>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>NO</th>
            <th>MENU</th>
            <th>ACCESS</th>
        </tr>
    </tfoot>                                    
   
</table>