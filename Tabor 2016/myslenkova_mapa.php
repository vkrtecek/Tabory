<div id="velky_toggle">
    <!--
    <div class="velky"  onmouseover="rozbal(1)" onmouseout="zabal(1)">
        <p class="menu">Menu 1</p>
        <div class="maly 1">
            <a href="#" onmouseover="rozbal(11)" onmouseout="zabal(11)">Item1</a>    
            	<div class="mensi 11"><a href="#">Item1</a></div>
                <div class="mensi 11"><a href="#">Item2</a></div>
                <div class="mensi 11"><a href="#">Item3</a></div>
            <a href="#" onmouseover="rozbal(12)" onmouseout="zabal(12)">Item2</a>
            	<div class="mensi 12"><a href="#">Item1</a></div>
                <div class="mensi 12"><a href="#">Item2</a></div>
                <div class="mensi 12"><a href="#">Item3</a></div>
            <a href="#" onmouseover="rozbal(13)" onmouseout="zabal(13)">Item3</a>
            	<div class="mensi 13"><a href="#">Item1</a></div>
                <div class="mensi 13"><a href="#">Item2</a></div>
                <div class="mensi 13"><a href="#">Item3</a></div>
        </div>
    </div>
    
    <div class="velky"  onmouseover="rozbal(2)" onmouseout="zabal(2)">
        <p class="menu">Menu 2</p>
        <div class="maly 2">
            <a href="#" onmouseover="rozbal(21)" onmouseout="zabal(21)">Item1</a>
            	<div class="mensi 21"><a href="#">Item1</a></div>
                <div class="mensi 21"><a href="#">Item2</a></div>
                <div class="mensi 21"><a href="#">Item3</a></div>
            <a href="#" onmouseover="rozbal(22)" onmouseout="zabal(22)">Item2</a>
            	<div class="mensi 22"><a href="#">Item1</a></div>
                <div class="mensi 22"><a href="#">Item2</a></div>
                <div class="mensi 22"><a href="#">Item3</a></div>
            <a href="#" onmouseover="rozbal(23)" onmouseout="zabal(23)">Item3</a>
            	<div class="mensi 23"><a href="#">Item1</a></div>
                <div class="mensi 23"><a href="#">Item2</a></div>
                <div class="mensi 23"><a href="#">Item3</a></div>
        </div>
    </div>
    -->
    
    <div class="velky_toggle"  onmouseover="rozbal(6)" onmouseout="zabal(6)">
        <p class="menu_toggle">Program jako takový</p>
        <div class="maly 6">
            <a href="#" title="">sprchy do programu</a>
            <hr />
            <a href="#" title="">motorky</a>
            <hr />
            <a href="#" title="">fotbal rádců</a>
            <hr />
            <a href="#" title="">sekera</a>
            <hr />
            <a href="#" title="">pašeráci</a>
            <hr />
            <a href="#" title="">Vsetín - koupák</a>
            <hr />
            <a href="#" title="">oheň? - i jindy s buřty</a>
            <hr />
            <a href="#" title="">flexibilita programu - lehce něco zrušit</a>
            <hr />
            <a href="#" title="">společný program se Světluškama</a>
            <hr />
            <a href="#" title="">odborky - jak?</a>
            <hr />
            <a href="#" title="">noční hra!</a>
            <hr />
            <a href="#" title="">širší nabídka odpoledňáku</a>
            <hr />
            <a href="#" title="">řízené volno</a>
        </div>
    </div>
    <div class="velky_toggle"  onmouseover="rozbal(1)" onmouseout="zabal(1)">
        <p class="menu_toggle">Táborový život</p>
        <div class="maly 1">
            <a href="#" title="">služby v kuchyni</a>
            <hr />
            <a href="#" title="">hlídky - jak?</a>
            <hr />
            <a href="#" title="">nástěnky - bodování stanů, mana, etapa</a>
        </div>
    </div>
    
    <div class="velky_toggle"  onmouseover="rozbal(2)" onmouseout="zabal(2)">
        <p class="menu_toggle">Individuální přístup</p>
        <div class="maly 2">
            <a href="#" title="">každý má svůj stan</a>
            <hr />
            <a href="#" title="">modlitební skupinky</a>
        </div>
    </div>
    
    <div class="velky_toggle"  onmouseover="rozbal(3)" onmouseout="zabal(3)">
        <p class="menu_toggle">Duchovní program</p>
        <div class="maly 3">
            <a href="#" title="">slůvko na den na nástěnku</a>
            <hr />
            <a href="#" title="">křížová cesta</a>
            <hr />
            <a href="#" title="">mše přes týden - oslovit kněze na JS</a>
        </div>
    </div>
    
    <div class="velky_toggle"  onmouseover="rozbal(4)" onmouseout="zabal(4)">
        <p class="menu_toggle">Pravidla</p>
        <div class="maly 4">
            <a href="#" title="">pro vedoucí i pro členy</a>
            <hr />
            <a href="#" title="">program dne na nástěnce</a>
            <hr />
            <a href="#" title="">definovat roli veldena</a>
            <hr />
            <a href="#" title="">"dotahovač" - kontroluje úklid po hrách</a>
            <hr />
            <a href="#" title="">pravidla srubu</a>
            <hr />
            <a href="#" title="">Buď příkladem!</a>
        </div>
    </div>
    
    <div class="velky_toggle"  onmouseover="rozbal(5)" onmouseout="zabal(5)">
        <p class="menu_toggle">Skauting</p>
        <div class="maly 5">
            <a href="#" title="">více pracovat s příkazem, slibem a zákonem</a>
            <hr />
            <a href="#" title="">signály morseovkou</a>
            <hr />
            <a href="#" title="">dpomluva s rodiči - vhodné kalhoty ke kroji</a>
            <hr />
            <a href="#" title="">dbát na kroj - mít s sebou ramínko</a>
            <hr />
            <a href="#" title="">příroda - více do ní chodit, aktivity v přírodě</a>
            <hr />
            <a href="#" title="">více skautských dovedností - formou hry</a>
        </div>
    </div>
    
</div>

<script type="text/javascript">
$('.maly').hide();
$('.mensi').hide();
function rozbal(e){	
	$('.'+e).show();
};
function zabal(e){
	$('.'+e).hide();
};
$(".maly  > a").mouseover(function(){
	$(this).css("color", "yellow");
});
$(".maly  > a").mouseout(function(){
	$(this).css("color", "#09F");
});
</script>