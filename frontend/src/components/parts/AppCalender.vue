<template>
  <FullCalendar :events="events" :options="dateOptions" />
</template>

<script lang="ts">
import { defineComponent, reactive } from 'vue'
import FullCalendar from 'primevue/fullcalendar'
import dayGridPlugin from '@fullcalendar/daygrid'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

type Props = {
  events: any[]
  initialDate: string
}

export default defineComponent({
  name: 'AppCalender',
  components: {
    FullCalendar
  },
  props: {
    events: {
      type: Array,
      default: () => {
        return []
      }
    },
    initialDate: {
      type: String,
      default: '2020-01-01'
    }
  },
  setup(props: Props) {
    const carendaerOptions = {
      plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
      initialDate: props.initialDate,
      headerToolbar: {
        left: 'prev,next',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
      },
      editable: true
    }
    // const events = reactive(eventDate)
    const dateOptions = reactive(carendaerOptions)

    // methods
    /**
     * catch app-input event
     * @return {void}
     */
    const catchAppInputEvent = (event: any) => {
      console.log('catchAppInputEvent: ' + JSON.stringify(event, null, 2))
    }
    return {
      dateOptions,
      catchAppInputEvent
    }
  }
})
</script>
