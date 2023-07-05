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
                        <div>{{ Number.isInteger(userScore.score) ? userScore.score : userScore.score.toFixed(1) }}</div>
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
                pointsData: '',
                userTotalScores: [],
            }
        },

        beforeMount() {
            this.getMatchDayPoints();
        },

        methods: {

            async getMatchDayPoints() {

                try {

                    const response = await axios.get('/api/points');
                    this.pointsData = response.data;

                    for (const userId in this.pointsData) {

                        let sum = 0;

                        this.pointsData[userId].match_days.forEach(matchday => {
                            sum += matchday.total_score
                        })

                        this.userTotalScores.push({user: this.pointsData[userId].name, score: sum});

                        function compareScore(a, b) {
                            let comparison = 0;
                            if (a.score > b.score) {
                                comparison = -1;
                            } else if (b.score > a.score) {
                                comparison = 1;
                            }
                            return comparison;
                        }

                        this.userTotalScores.sort(compareScore);
                    }
                }
                catch (error) {
                    console.log(error);
                }
            }
        }
    }

</script>
