<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import TextInput from '@/Components/TextInput.vue';
    import Swal from 'sweetalert2';
    import { Head } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/vue3';

    const props = defineProps({
        user:{type:Object,default:() => ({})},
        saldo:{type:String},
        excedido:{type:String},
        mensajeerror:{type:String},
        retiro: Array,
    });

    const form = useForm({
        saldo:props.user.saldo,
    });
    
    const save = () =>{
        form.post(route('historial.store'));
    }
</script>
<template>
    <Head title="Tareas" />
    <AuthenticatedLayout>
        <template #header>
            <div class="container-fluid mt-3 bg-white">
                <div class="row mt-3">
                    <div class="col-md-12 offset-md-12">
                        <span> Retiros</span><br>
                        monto:<span > {{ saldo }}</span>
                    </div>
                </div>
                <div>
                    <form @submit.prevent="save()">
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-music"></i></span>
                            <TextInput :id="'saldo'" class="form-control" type="text" name="saldo" v-model="form.saldo" aria-placeholder="Ingrese Monto a Retirar" required></TextInput>
                        </div>
                        <div v-if="form.errors.saldo" class="text-sm text-danger">
                            {{ form.errors.saldo }}
                        </div>
                        
                        <div class="alert alert-danger" role="alert" v-if="excedido == true">
                            {{ mensajeerror }}
                        </div>

                        <div class="alert alert-success" role="alert" v-if="excedido == 'exitoso'">
                            Retiro Exitoso
                        </div>

                        <div class="d-grid mx-auto">
                            <button class="btn btn-success" :disabled="form.processing">
                                <i class="fa-solid fa-floppy-disk"></i> Retirar
                            </button>
                        </div>
                    </form>
                </div>
                
                    <ul>
                        <li v-for="(mensaje, index) in retiro" :key="index">
                        {{ mensaje }}
                        </li>
                    </ul>
            </div>
        </template>
    </AuthenticatedLayout>
</template>