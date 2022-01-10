<template>
    <!-- propsでvalueを受け取り、フォームに何か入力したら$emit('input', $event)で親コンポーネントにその値を返す -->
    <v-textarea
        filled
        rounded
        auto-grow
        :value="value"
        @input="$emit('input', $event)"
        placeholder="詳細"
        rows="4">
    </v-textarea>
</template>

<script>
export default {
    name: 'TextForm',
    props: ['value'],
}
</script>
