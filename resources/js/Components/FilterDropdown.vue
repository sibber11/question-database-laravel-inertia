<script setup>

const props = defineProps({
    options: {
        type: Object,
        required: false,
    },
    field: {
        type: String,
        required: true
    },
    placeholder: {
        type: String,
        default(p) {
            return 'Filter by ' + p.field + '...';
        }
    },
    remote: {
        type: Boolean,
        default: false,
    },
    route_name: {
        type: String,
        required: false,
    }
})

const {search} = useSearchFilter(props.field);
const model = defineModel();

watch(model, () => {
    search.value = model.value?.id;
})

function getRoute() {
    if (props.route_name)
        return props.route_name;
    return 'remote.' + props.field.replace('_id', 's');
}
</script>

<template>
    <Select v-if="!remote" v-model="search" :placeholder="placeholder"
            class-input="pr-8">
        <option v-for="(opt, index) in options" :value="opt.id ?? index">{{ opt.value ?? opt }}</option>
    </Select>
    <CustomVueSelect v-else v-model="model" :label="field" :placeholder="placeholder"
                     :route-name="getRoute()" hide-label/>
</template>

<style lang="scss" scoped>

</style>
