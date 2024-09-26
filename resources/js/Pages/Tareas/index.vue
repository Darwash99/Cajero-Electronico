<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Swal from 'sweetalert2';
    import { Head } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';
    import ModalesTarea from '@/Components/ModalesTarea.vue';
import InputLabel from '@/Components/InputLabel.vue';

    const form = useForm({});
    const props = defineProps({
        tareas:{type:Object}
    });

    const eliminar = (id,titulo) =>{
        const Swalbu = Swal.mixin({
            buttonsStyling:true
        })
        Swalbu.fire({
            title:'Seguro de eliminar la tarea?' + titulo,
            text: 'se perdera la tarea',
            icon: 'question',
            showCancelButton:true,
            confirmButtonText: '<i class="fa-solid fa-check"></i> Si, eliminar',
            cancelButtonText: '<i class="fa-solid fa-ban"></i> Cancelar',
        }).then((result) => {
            if(result.isConfirmed){
                form.delete(route('tareas.destroy',id));
            }
        })
    }

    const abrieditar = (tarea) =>{
        document.getElementById('id2').value = tarea.id;
        document.getElementById('titulo2').value = tarea.titulo;
        document.getElementById('autor2').value = tarea.autor;
        document.getElementById('album2').value = tarea.album;
    }
</script>
<template>
    <Head title="Tareas" />
    <AuthenticatedLayout>
        <template #header>
            <div class="container-fluid mt-3 bg-white">
                <div class="row mt-3">
                    <div class="col-md-4 offset-md-4">
                        <div class="d-grid mx-auto">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalcreate">
                                <i class="fa-solid fa-circle-plus"></i>Añadir
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-10 offset-md-1">
                        <div class="table-responsive">
                            <table class="table table-stripeted table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>titulo</th>
                                        <th>autor</th>
                                        <th>album</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="tarea, i in tareas" :key="tarea.id">
                                        <td>{{ i++ }}</td>
                                        <td>{{ tarea.titulo }}</td>
                                        <td>{{ tarea.autor }}</td>
                                        <td>{{ tarea.album }}</td>
                                        <td> 
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modaledit" @click="abrieditar(tarea)">
                                                <i class="fa-solid fa-edit"></i>
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger" @click="eliminar(tarea.id,tarea.titulo)">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <ModalesTarea :modal="'modalcreate'" :title="'Añadir Tarea'" :op="'1'"></ModalesTarea>
            <ModalesTarea :modal="'modaledit'" :title="'Editar Tarea'" :op="'2'"></ModalesTarea>
        </template>
    </AuthenticatedLayout>
</template>