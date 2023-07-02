<template>
    <Head title="Rules" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rules</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="(rule, index) in rules" class="border-b border-gray-100 border-1 w-full text-lg py-6 px-8">
                        <div class="w-full flex justify-between">
                           <div class="capitalize font-semibold mb-1">
                                {{ index + 1}}. {{ rule.name }}
                            </div>
                            <div>
                                {{ rule.points }} {{ rule.points == 1 || rule.points == -1 ? 'point' : 'points' }}
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <div>
                            {{ rule.description }}
                            </div>
                            <div class="flex justify-around">
                                <button @click="editRule(rule)" class="text-gray-300 hover:bg-black hover:text-white px-2 py-1 rounded-lg text-xs ml-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button @click="deleteRule(rule)" class="text-red-300 hover:bg-red-500 hover:text-white px-2 py-1 rounded-lg text-xs ml-2">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button @click="showModal = true" class="bg-white mt-4 mr-4 p-4 rounded-md hover:bg-black hover:text-white">
                            Add rule
                    </button>
                </div>
            </div>
            <Modal :show="showModal">
                <div class="p-4">
                    <div class="font-semibold">
                        {{ ruleBeingEdited.id ? 'Editing' : 'Creating'}} rule...
                    </div>
                    <div class="m-2">
                        <label for="ruleNameEdit" class="m-2">Name</label>
                        <input id="ruleNameEdit" v-model.trim="ruleBeingEdited.name" style="width: 90%" class="mt-2 text-gray-500 mx-8 p-2 rounded-lg focus:outline-none focus:text-black"
                            :class="{'bg-gray-100' : !ruleBeingEdited.id}">
                    </div>
                    <div class="m-2">
                        <label for="ruleDescriptionEdit" class="m-2">Description</label>
                        <input id="ruleDescriptionEdit" v-model.trim="ruleBeingEdited.description" style="width: 90%" class="mt-2 text-gray-500 mx-8 p-2 rounded-lg focus:outline-none focus:text-black"
                            :class="{'bg-gray-100' : !ruleBeingEdited.id}">
                    </div>
                    <div class="m-2">
                        <label for="rulePointsEdit" class="m-2">Points</label>
                        <input id="rulePointsEdit" v-model.number="ruleBeingEdited.points" style="width: 90%" class="mt-2 text-gray-500 mx-8 p-2 rounded-lg focus:outline-none focus:text-black"
                            :class="{'bg-gray-100' : !ruleBeingEdited.id}">
                    </div>
                    <div class="mx-4 mb-2 mt-8 gap-y-2 grid grid-cols-1 md:flex md:justify-around">
                        <button @click="updateRule()" class="text-lg p-4 rounded-md bg-green-500 hover:bg-green-400 hover:shadow-lg text-white">
                            Confirm
                        </button>
                        <button @click="cancelEdittingRule()" class="text-lg p-4 rounded-md bg-gray-500 hover:bg-gray-400 hover:shadow-lg text-white">
                            Cancel
                        </button>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import Modal from '@/Components/Modal.vue';
</script>
<script>
    export default {

        props: {

        },

        data() {
            return {
                rules: '',
                ruleBeingEdited: {
                    id: '',
                    name: '',
                    description: '',
                    points: ''
                },
                showModal: false,
            }
        },
        beforeMount() {
            this.getRules();
        },

        methods: {

            async getRules() {

                try {
                    let response = await axios.get('/api/rules');
                    this.rules = response.data.data;
                }
                catch (error) {
                    console.log(eror);
                }
            },

            async deleteRule(rule) {
                let userResponse = await swal.fire({
                    icon: "warning",
                    title: "Are you sure?",
                    text: "Are you sure you want to delete '" + rule.name + "' as a rule?",
                    showConfirmButton: true,
                    showDenyButton: true,
                });

                if (userResponse.isConfirmed) {
                    try {
                        let apiResponse = await axios.delete('/api/rules/' + rule.id);

                        if (apiResponse.data.status == 'OK') {

                            swal.fire({
                                icon: "success",
                                title: "Nice",
                                showConfirmButton: false,
                                showDenyButton: false,
                                timer: 600
                            });

                            this.cancelEdittingRule();
                            this.getRules();
                        }
                    }
                    catch (error) {
                        console.log(error);
                    }
                }
            },

            editRule(rule) {
                this.ruleBeingEdited = rule;
                this.showModal = true;
            },

            cancelEdittingRule() {
                this.showModal = false;
                this.ruleBeingEdited = {};
            },

            async updateRule() {
                try {
                    let userResponse = await swal.fire({
                        icon: "warning",
                        title: "Wait",
                        text: "Are you sure you want to update this rule?",
                        showConfirmButton: true,
                        showDenyButton: true
                    });

                    if (userResponse.isConfirmed) {

                        let httpVerb = 'post';
                        let apiEndPoint = '/api/rules';

                        if (this.ruleBeingEdited.id) {
                            httpVerb = 'put';
                            apiEndPoint = '/api/rules/' + this.ruleBeingEdited.id;
                        }


                        let apiResponse = await axios[httpVerb](apiEndPoint, this.ruleBeingEdited);

                        if (apiResponse.data.status == 'OK') {

                            swal.fire({
                                icon: "success",
                                title: "Nice",
                                showConfirmButton: false,
                                showDenyButton: false,
                                timer: 600
                            });

                            this.cancelEdittingRule();
                            this.getRules();
                        }
                    }
                }
                catch (error) {
                    console.log(error);

                    swal.fire({
                        icon: "error",
                        title: "Uh oh",
                        text: error.response.data.message
                    });
                }
            },
        }
    }

</script>
