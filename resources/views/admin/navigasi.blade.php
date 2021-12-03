<div  class="app-sidebar app-navigation scroll app-navigation-fixed app-navigation-style-purple dir-left app-navigation-open-hover" data-type="close-other">
    <a href="{{ url('/devadmin/dashboard')}}" class="app-navigation-logo" style="background: url({{asset('halamanlogin/img/img-01.png')}}) left top no-repeat #f7c36e;background-size: 55px auto;"></a>
    <nav>
    <ul>
        <?php 
            $sesdata = session()->get('role_id');
            $getuser = DB::table('user')->where('role_id',$sesdata)->where('is_active',1)->first();
            $cekuserakses = DB::table('user_access_menu')->where('role_id',$getuser->role_id)->orderBy('orderby','ASC')->get(); 
        ?>
        @foreach($cekuserakses as $akses)
            <?php $datamenu = DB::table('user_title_menu')->where('id',$akses->menu_id)->first(); ?>

                <li class="title">{{$datamenu->menu}}</li>

                <?php  
                $menuuu = DB::table('user_menu')->where('id_titile_menu',$datamenu->id)->get(); ?>
                @foreach($menuuu as $men)
                <?php if($men->id == 1){ ?>
                        <?php  
                        $submenusingle = DB::table('user_sub_menu')->where('menu_id',$men->id)->where('is_active',1)->get(); ?>
                        @foreach($submenusingle as $submens)
                            <li><a href="{{ url($submens->url)}}" class="{{ (request()->is($submens->url)) ? 'active' : '' }}"><span class="fa {{$submens->icon}}"></span> {{$submens->title}}</a></li>
                        @endforeach

                <?php }else{ 
                            $submenucek = DB::table('user_sub_menu')->where('title',$page)->first(); ?>
                        <li class="openable {{ $men->id == $submenucek->menu_id ? 'open' : '' }}">
                            <a href="#"><span class="fa {{$men->icon}}"></span>{{$men->menu}}</a>
                            <ul>
                                <?php  
                                $submenuu = DB::table('user_sub_menu')->where('menu_id',$men->id)->where('is_active',1)->get(); ?>
                                @foreach($submenuu as $submen)
                                    <li><a href="{{ url($submen->url)}}" class="{{ (request()->is($submen->url)) ? 'active' : '' }}"><span class="fa {{$submen->icon}}"></span> {{$submen->title}}</a></li>
                                @endforeach
                            </ul>
                        </li>
                <?php } ?>
                

                @endforeach

        @endforeach



    </ul>
    </nav>
</div>
