<template>
    <Head :title="'Match ' + matchId" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Scoreboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="user in Object.keys(userDays)" class="border-b border-gray-100 border-1 w-full text-lg py-6 px-8">
                        <div>
                            {{user}} - Total: {{ 0 }}
                        </div>
                        <div class="flex w-full justify-between">
                            <div v-for="userDay in userDays[user]" class="">
                                <input type="text" size="1" :value="userDay.total_score" disabled="true" class="rounded-lg bg-gray-100">
                                <button @click="showModalForUserDay(userDay)" class="bg-green-200 p-2 rounded-lg text-sm ml-2">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Apply score rule modal -->
                    <Modal :show="showModal">
                        <div class="m-4">
                            <div class="flex justify-between">
                                <div>
                                    {{ userDayInFocus.user.name }} - Match {{ matchId }}, Day {{ userDayInFocus.match_day_id }}
                                </div>
                                <button @click="closeModal()">
                                    Exit <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div v-if="pointsArrayInFocus.length">
                                This user has already scored points on this day for:
                                <ul v-for="score in pointsArrayInFocus">
                                    <li>score</li>
                                </ul>
                            </div>
                            <div v-else>
                                No scores for this day yet...
                            </div>
                            <div class="p-2">
                                <label for="ruleSelection">Rule:</label>
                                <select id="ruleSelection" v-model="selectedRule" class="m-2 rounded-lg">
                                    <option v-for="rule in rules" :value="rule">{{rule.name}}</option>
                                </select>
                            </div>
                            <div class="p-2">
                                <label for="playerNomination">Player:</label>
                                <input id="playerNomination" type="text" v-model="nominatedPlayer" class="m-2 rounded-lg">
                            </div>
                            <button @click="saveNewPointScore()">
                                Save
                            </button>
                        </div>
                    </Modal>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import Modal from '@/Components/Modal.vue';
    import { Head } from '@inertiajs/vue3';
</script>
<script>
    export default {

        props: {
            matchId: Number
        },

        data() {
            return {
                showModal: false,
                userDays: '',
                userDayInFocus: '',
                pointsArrayInFocus: [],
                rules: '',
                selectedRule: '',
                nominatedPlayer: '',
            }
        },
        beforeMount() {
            this.getUserDayData();
            this.getRulesData();
        },

        methods: {

            getUserDayData() {
                axios.get('/api/points/' + this.matchId).then(response => {
                    this.userDays = response.data.data;
                })
            },

            getRulesData() {
                axios.get('/api/rules').then(response => {
                    this.rules = response.data.data;
                })
            },

            showModalForUserDay(userDay) {
                this.showModal = true;
                this.userDayInFocus = userDay;
                this.pointsArrayInFocus = JSON.parse(userDay.rule_points_array);
            },

            closeModal() {
                this.showModal = false;
                this.userDayInFocus = '';
                this.pointsArrayInFocus = [];
                this.selectedRule = '';
                this.nominatedPlayer = '';
            },

            saveNewPointScore() {

                if (this.selectedRule && this.nominatedPlayer) {

                    let newPointsArray = this.pointsArrayInFocus;

                    newPointsArray.push({'rule': this.selectedRule.name, 'player': this.nominatedPlayer});

                    const pointsArray = JSON.stringify(newPointsArray);

                    axios.put('/api/points/' + this.userDayInFocus.id, {'points_array': pointsArray}).then(response => {

                        if (response.data.status == 'OK') {
                            this.getUserDayData();
                            this.closeModal();
                        }
                    });
                }
            },

            removePointScore() {

            },
        }
    }

</script>
