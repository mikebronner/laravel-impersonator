<script>
export default {
    data: function () {
        return {
            isLoading: true,
            impersonatees: [],
        };
    },

    mounted() {
        this.loadImpersonatees();
    },

    methods: {
        impersonate: function (userId) {
            var self = this;

            Nova.request().put("/genealabs/laravel-impersonator/nova/impersonatees/" + userId)
                .then(function (response) {
                    window.location.href = "/dashboard";
                })
                .catch(function (error) {
                    console.error(error.data);
                });
        },

        loadImpersonatees: function () {
            var self = this;

            Nova.request().get("/genealabs/laravel-impersonator/nova/impersonatees")
                .then(function (response) {
                    console.log(response.data);
                    self.isLoading = false;
                    self.impersonatees = response.data;
                })
                .catch(function (error) {
                    console.error(error.data);
                });
        },
    },
};
</script>

<template>
    <div>
        <heading class="mb-6">Impersonate Users</heading>

        <loading-card
            :loading="isLoading"
        >
            <div class="overflow-hidden overflow-x-auto relative">
                <table cellpadding="0" cellspacing="0" class="table w-full">
                    <thead>
                        <tr>
                            <th class="text-left">
                                <span dusk="sort-name" class="cursor-pointer inline-flex items-center">
                                    Name
                                </span>
                            </th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(impersonatee, index) in impersonatees"
                            :key="index"
                        >
                            <td>
                                <span
                                    class="whitespace-no-wrap text-left"
                                    v-text="impersonatee.name"
                                ></span>
                            </td>
                            <td class="text-right">
                                <span
                                    @click="impersonate(impersonatee.id)"
                                    class="cursor-pointer text-70 hover:text-primary mr-3"
                                    title="Impersonate"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="18" viewBox="0 0 22 16" aria-labelledby="view" role="presentation" class="fill-current"><path d="M16.56 13.66a8 8 0 0 1-11.32 0L.3 8.7a1 1 0 0 1 0-1.42l4.95-4.95a8 8 0 0 1 11.32 0l4.95 4.95a1 1 0 0 1 0 1.42l-4.95 4.95-.01.01zm-9.9-1.42a6 6 0 0 0 8.48 0L19.38 8l-4.24-4.24a6 6 0 0 0-8.48 0L2.4 8l4.25 4.24h.01zM10.9 12a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0-2a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"></path></svg>
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </loading-card>
    </div>
</template>

<style scoped lang="scss">
    //
</style>
