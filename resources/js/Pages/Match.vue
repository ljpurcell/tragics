<template>
    <Head :title="'Match ' + id" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scoreboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="user in Object.keys(data)" class="border-b border-gray-100 border-1 flex w-full justify-between text-lg py-6 px-8">
                        {{user}}
                        <div class="flex w-full justify-between">
                            <div v-for="day in data[user]">
                            {{ day.total_score }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
</script>
<script>
    export default {

        props: {
            id: String
        },

        data() {
            return {
                data: '',
            }
        },
        beforeMount() {
            this.getData();
        },

        methods: {

            getData() {
                axios.get('/api/points/' + this.id).then(response => {
                    this.data = response.data;
                })
            }
        }
    }

</script>
