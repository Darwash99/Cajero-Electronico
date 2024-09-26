<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Swal from 'sweetalert2';
    import { Head } from '@inertiajs/vue3';

    const props = defineProps({
        data:{type:Object}
    });

</script>
<template>
    <Head title="Reporte" />
    <AuthenticatedLayout>
        <template #header>
            <div class="container-fluid mt-3 bg-white">
                
                <div class="row mt-3">
                    <div class="col-md-10 offset-md-1">
                        <div class="table-responsive">
                            <table class="table table-stripeted table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nombre usuario</th>
                                        <th>Correo Electronico</th>
                                        <th>Total Saldo actual</th>
                                        <th>Suma Retiros exitosos</th>
                                        <th>Suma Retiros Fallidos</th>
                                        <th>Maximo Retiro Exitoso</th>
                                        <th>Suma Retiros Fallidos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="reporte,i in data" :key="index">
                                        <td>{{ i++ }}</td>
                                        <td>{{ reporte.name }}</td>
                                        <td>{{ reporte.email }}</td>
                                        <td>{{ reporte.saldo }}</td>
                                        <td>{{ reporte.suma_retiros_exitosos }}</td>
                                        <td>{{ reporte.suma_retiros_fallidos }}</td>
                                        <td>{{ reporte.saldo_retiro_exitoso }}</td>
                                        <td>{{ reporte.max_retiro_fallido }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </AuthenticatedLayout>
</template>