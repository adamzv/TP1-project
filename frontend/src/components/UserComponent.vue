<template>
    <b-table :data="data" :columns="columns"></b-table>

    
</template>

<script>
    export default {
        props: {
            users: {
                type: Array,
                required: true
            }
        },

        data() {
            return {
                data: this.users,
                columns: [
                    {
                        field: 'id',
                        label: 'ID',
                        width: '40',
                        numeric: true
                    },
                    {
                        field: 'name',
                        label: 'Meno',
                    },
                    {
                        field: 'surname',
                        label: 'Priezvisko',
                    },
                    {
                        field: 'email',
                        label: 'Email',
                    },
                     {
                        field: 'id_role',
                        label: 'Rola',
                    },
                    
                ]
            }
        },
        watch: {
            users() {
                if (this.users.length > 0) {
                this.data = this.users;
                }
            }
        },
    }
</script>