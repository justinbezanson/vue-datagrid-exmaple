<template>
    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4">
        <div>
            <!--TODO: results per page-->
        </div>

        <div class="text-right mb-6">
            <img 
                v-show="isSearching" 
                src="../../images/3-dots-move.svg" 
                title="Loading..." 
                alt="Loading..." 
                class="inline" 
            />
            
            <span class="pr-2">Search:</span>

            <TextInput
                id="search"
                v-model="search"
                type="text"
            />
        </div>
    </div>

    <table class="w-full">
        <thead>
            <tr class="border-b  border-gray-600">
                <th v-for="column in props.columns">{{ column.header }}</th>
            </tr>
        </thead>
        <tbody>
            <tr 
                v-for="(row, index) in props.data.data"
                :key="row[props.keyColumn]"
                class="border-t border-gray-300 hover:bg-gray-100"
                :class="index%2==0 ? 'bg-gray-50': ''"
            >
                <td class="py-2" v-for="column in props.columns">{{ row[column.column] }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="border-t  border-gray-600">
                <th v-for="column in props.columns">{{ column.header }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="grid lg:grid-cols-2 sm:grid-cols-1 gap-4 mt-4">
        <div class="flex items-center text-gray-500 text-sm">Showing {{ props.data.from }} to {{ props.data.to }} of {{ props.data.total }}</div>

        <div class="text-right">
            <Pagination class="float-right" :links="props.data.links" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps(['data', 'columns', 'keyColumn', 'searchRoute', 'currentSearch']);

const search = ref(props.currentSearch);

const searchForm = useForm({
    search: ''
});

let isSearching = ref(false);

let timeout = null;

watch(search, async (newSearch, oldSearch) => {
    if(newSearch === oldSearch) {
        return;
    }

    searchForm.search = search;

    if (typeof timeout === "number") {
        clearTimeout(timeout);
    }

    timeout = setTimeout(datagridSearch, 1000);
})

const datagridSearch = async () => {
    isSearching.value = true;

    try {
        searchForm.get('/', {
            onFinish: () => { isSearching.value = false; }
        });
    } catch (error) {
      //throw error
    } finally {
      clearTimeout(timeout);
    }
};

onMounted(() => {
    document.getElementById('search').focus();
});
</script>