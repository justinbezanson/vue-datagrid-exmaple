<template>
    <div class="m-8">
        <DataGrid
            :data="props.customers" 
            :columns="columns"
            keyColumn="id"
            searchRoute="customer"
            :currentSearch="props.search"
        />
    </div>
</template>

<script setup>
import DataGrid from '@/Components/DataGrid.vue';

const props = defineProps(['customers', 'search']);

const columns = [
    {
        header: 'Name',
        column: 'name'
    },
    {
        header: 'City',
        column: 'city'
    },
    {
        header: 'State',
        column: 'state'
    },
    {
        header: 'Phone',
        column: 'phone'
    },
    {
        header: 'Email',
        column: 'email'
    }
];
</script>