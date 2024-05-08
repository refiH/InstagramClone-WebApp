<template>
  <p class="text-sm text-gray-400" :title="formatDate(date)">
    {{ formatTime(date) }}
  </p>
</template>

<script>
import formatTime from '../Utils/formatTime';
import formatDate from '../Utils/formatDate';

export default {
  props: {
    date: String,
  },
  setup() {
    return {
      formatTime,
      formatDate,
    };
  },
};
</script>
