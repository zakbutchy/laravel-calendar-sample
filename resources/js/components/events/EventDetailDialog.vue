<template>
    <v-card class="pb-12">
        <v-card-actions class="d-flex justify-end pa-2">
            <v-btn icon @click="editEvent">
                <v-icon size="20px">mdi-pencil-outline</v-icon>
            </v-btn>
            <v-btn icon @click="removeEvent">
                <v-icon size="20px">mdi-trash-can-outline</v-icon>
            </v-btn>
            <v-btn icon @click="closeDialog" :color="event.color">
                <v-icon size="20px">mdi-close</v-icon>
            </v-btn>
        </v-card-actions>
        <v-card-title>
            <DialogSection icon="mdi-square">
                {{ event.name }}
            </DialogSection>
        </v-card-title>
        <v-card-text>
            <DialogSection icon="mdi-clock-time-three-outline">
                {{ event.startDate }} {{ event.timed ? event.startTime : '' }} ~ {{ event.endDate }} {{ event.timed ? event.endTime : '' }}
            </DialogSection>
        </v-card-text>
        <v-card-text>
            <DialogSection icon="mdi-card-text-outline">
                {{ event.description || 'no description' }}
            </DialogSection>
        </v-card-text>
        <v-card-text>
            <DialogSection icon="mdi-calendar">{{ event.calendar.name }}</DialogSection>
        </v-card-text>
    </v-card>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import DialogSection from '../pageParts/DialogSection';

export default {
    name: 'EventDetailDialog',
    computed: {
        ...mapGetters('events', ['event']),
    },
    components: {
        DialogSection,
    },
    methods: {
        ...mapActions('events', ['setEvent', 'deleteEvent', 'setEditMode']),
        closeDialog() {
            this.setEvent(null);
        },
        editEvent() {
            this.setEditMode(true);
        },
        removeEvent() {
            this.$swal({
                title: "Caution!",
                html: `「${this.event.name}」を削除してもよろしいですか？`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete'
            }).then(result => {
                if (result.value) {
                    this.deleteEvent(this.event.id);
                    this.$swal(
                        'OK!',
                        'イベントを削除しました。',
                        'success'
                    )
                }
            });
        },
    }
};
</script>
