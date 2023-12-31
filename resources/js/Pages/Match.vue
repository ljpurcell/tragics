<template>
    <Head :title="'Match ' + matchId" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Match {{matchId}}</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="user in Object.keys(userDays)" class="border-b border-gray-100 border-1 w-full text-lg py-6 px-8">
                        <div>
                            {{user}} - Total: {{Number.isInteger( userTotalScores[user] ) ?  userTotalScores[user]  : Number( userTotalScores[user] ).toFixed(1)}}
                        </div>
                        <div class="flex w-full justify-between">
                            <div v-for="userDay in userDays[user]" class="">
                                <input type="text" size="2" :value="Number.isInteger(userDay.total_score) ? userDay.total_score : Number(userDay.total_score).toFixed(1)" disabled="true" class="rounded-lg bg-gray-100">
                                <button @click="showModalForUserDay(userDay)" class="text-gray-300 hover:bg-black hover:text-white px-2 py-1 rounded-lg text-sm ml-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Apply score rule modal -->
                    <Modal :show="showModal">
                        <div class="m-4">
                            <div class="flex justify-between text-lg mb-4">
                                <div class="">
                                    {{ userDayInFocus.user.name }} - Match {{ matchId }}, Day {{ userDayInFocus.match_day_id }}
                                </div>
                                <button @click="closeModal()" class="text-gray-500 p-1">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                            <div v-if="pointsArrayInFocus.length">
                                {{ userDayInFocus.user.name }} has already scored points on this day for:
                                <ul v-for="(score, index) in pointsArrayInFocus" class="m-4">
                                    <li><span class="font-semibold">{{score.rule}}</span> - <span class="capitalize">{{score.player}}</span> ({{Number.isInteger(score.points) ? score.points : Number(score.points).toFixed(1)}} pts)
                                        <button @click="removePointScore(index)" class="text-red-300 text-xs hover:text-red-400 p-1 mx-2">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <div v-else>
                                No scores for this day yet...
                            </div>
                            <div class="grid grid-cols-1 md:flex md:justify-around">
                                <div class="p-2">
                                    <label for="ruleSelection" class="pl-3">Rule:</label>
                                    <select id="ruleSelection" v-model="selectedRule" class="w-full m-2 rounded-lg">
                                        <option value="" selected disabled></option>
                                        <option v-for="rule in rules" :value="rule">{{rule.name}}</option>
                                    </select>
                                </div>
                                <div class="p-2">
                                    <label for="playerNomination" class="pl-3">Player:</label>
                                    <input id="playerNomination" type="text" v-model="nominatedPlayer" class="w-full m-2 rounded-lg">
                                    <div class="flex justify-end text-xs pr-2 text-gray-500" :class="{ 'opacity-0' : !selectedRule || nominatedPlayer }">Please nominate the player as well</div>
                                </div>
                            </div>
                            <div class="flex flex-col items-center mt-4">
                                <button @click="addNewPointScore()" class="text-lg p-4 rounded-md bg-green-500 hover:bg-green-400 text-white">
                                    Save
                                </button>
                            </div>
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
                userTotalScores: {},
            }
        },
        beforeMount() {
            this.getUserDayData();
            this.getRulesData();
        },

        methods: {

            async getUserDayData() {
                try {

                    let response = await axios.get('/api/points/' + this.matchId)
                    this.userDays = response.data.data;

                    Object.keys(this.userDays).forEach( user => {

                        let sum = 0;

                        this.userDays[user].forEach(matchDay => {
                            sum += matchDay.total_score
                        })

                        this.userTotalScores[user] = sum;
                    })
                }
                catch (error) {
                    console.log(error);
                }
            },

            async getRulesData() {
                try {
                    let response = await axios.get('/api/rules');
                    this.rules = response.data.data;
                }
                catch (error) {
                    console.log(error);
                }
            },

            showModalForUserDay(userDay) {
                this.showModal = true;
                this.userDayInFocus = userDay;

                if (userDay.rule_points_array != '[]') {
                    this.pointsArrayInFocus = JSON.parse(JSON.parse(userDay.rule_points_array)); // rule_points_array is over stringified, so JSON.parse is required twice
                } else {
                    this.pointsArrayInFocus = [];
                }
            },

            clearAttributesInFocus() {
                this.selectedRule = '';
                this.nominatedPlayer = '';
            },

            closeModal() {
                this.userDayInFocus = '';
                this.pointsArrayInFocus = [];
                this.showModal = false;
                this.clearAttributesInFocus();
            },

            addNewPointScore() {

                if (this.selectedRule && this.nominatedPlayer) {

                    this.pointsArrayInFocus.push({'rule': this.selectedRule.name, 'player': this.nominatedPlayer, 'points': this.selectedRule.points});

                    this.savePointsArray();
                }
            },

            async removePointScore(index) {

                let response = await swal.fire({
                    icon: "warning",
                    title: "Wait",
                    text: "Are you sure you want to delete this score?",
                    showConfirmButton: true,
                    showDenyButton: true,
                });

                if (response.isConfirmed) {

                    this.pointsArrayInFocus.splice(index, 1);

                    this.savePointsArray();
                }

            },

            async savePointsArray() {

                try {

                    const pointsArray = JSON.stringify(this.pointsArrayInFocus);

                    let response = await axios.put('/api/points/' + this.userDayInFocus.id, {'points_array': pointsArray});

                    if (response.statusText == 'OK') {
                        this.getUserDayData();
                        this.clearAttributesInFocus();
                    }
                }
                catch(error) {
                    console.log(error);
                }

            }
        }
    }

</script>
