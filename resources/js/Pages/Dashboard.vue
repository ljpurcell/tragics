<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <button @click="getData()">
                        Click here
                    </button>
                    <pre>{{userTotalScores}}</pre>
                    <pre>{{data}}</pre>
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

        data() {
            return {
                data: '',
                userTotalScores: [],
            }
        },

        methods: {

            getData() {
                axios.get('/api/points').then(response => {
                    const pointsData = response.data;
                    this.data = response.data;

                    for (const userId in pointsData) {

                        let sum = 0;

                        pointsData[userId].match_days.forEach(matchDay => {
                            sum += matchDay.total_score
                        })

                        this.userTotalScores.push({user: pointsData[userId].name, score: sum});
                    }

                    // could sort by score...
                })
            }
        }
    }

</script>
