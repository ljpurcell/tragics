<template>
    <Head title="Scoreboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scoreboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div v-for="userScore in userTotalScores" class="border-b border-gray-100 border-1 flex w-full justify-between text-lg py-6 px-8">
                        <div>{{userScore.user}}</div>
                        <div>{{userScore.score}}</div>
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

        data() {
            return {
                data: '',
                userTotalScores: [],
            }
        },
        beforeMount() {
            this.getData();
        },

        methods: {

            getData() {
                axios.get('/api/points').then(response => {
                    const pointsData = response.data;
                    this.data = response.data;

                    for (const userId in pointsData) {

                        let sum = 0;

                        pointsData[userId].match_days.forEach(matchday => {
                            sum += matchday.total_score
                        })

                        this.userTotalScores.push({user: pointsData[userId].name, score: sum});
                    }

                    // could sort by score...
                })
            }
        }
    }

</script>
