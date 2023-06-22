<template>
    <Head :title="'Match ' + id" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scoreboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="(rule, index) in data" class="border-b border-gray-100 border-1 w-full text-lg py-6 px-8">
                        <div class="w-full flex justify-between">
                           <div class="capitalize font-semibold mb-1">
                                {{ index + 1}}. {{ rule.name }}
                            </div>
                            <div>
                                {{ rule.points }} {{ rule.points == 1 || rule.points == -1 ? 'point' : 'points' }}
                            </div>
                        </div>
                        <div>
                            {{ rule.description }}
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
                axios.get('/api/rules/').then(response => {
                    this.data = response.data.data;
                })
            }
        }
    }

</script>
