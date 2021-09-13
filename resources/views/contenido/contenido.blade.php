    @extends('principal')
    @section('contenido')

    @if(Auth::check())
            @if (Auth::user()->id_rol == 1)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>
            
            <template v-if="menu==1">
                <facebook></facebook>
            </template>

            <template v-if="menu==2">
                <h1>Publicar</h1>
            </template>

            <template v-if="menu==3">
                <h1>Agregar Proyecto</h1>
            </template>

            <template v-if="menu==4">
                <h1>Pagina web</h1>
            </template>

            <template v-if="menu==5">
                <user></user>
            </template>

            <template v-if="menu==6">
                <rol></rol>
            </template>

            <template v-if="menu==7">
                <h1>Reporte Instagram</h1>
            </template>

            <template v-if="menu==8">
                <h1>Reporte Pagina web</h1>
            </template>

            <template v-if="menu==9">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>
            @elseif (Auth::user()->id_rol == 2)
            <template v-if="menu==0">
                <h1>Escritorio</h1>
            </template>
            
            <template v-if="menu==1">
                <h1>Vincular redes sociales</h1>
            </template>

            <template v-if="menu==2">
                <h1>Publicar</h1>
            </template>

            <template v-if="menu==3">
                <h1>Agregar Proyecto</h1>
            </template>

            <template v-if="menu==4">
                <h1>Pagina web</h1>
            </template>

            <template v-if="menu==7">
                <h1>Reporte Instagram</h1>
            </template>

            <template v-if="menu==8">
                <h1>Reporte Pagina web</h1>
            </template>

            <template v-if="menu==9">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==10">
                <h1>Acerca de</h1>
            </template>
            @else

            @endif
    @endif

    @endsection