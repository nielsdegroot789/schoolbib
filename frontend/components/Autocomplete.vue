<template>
  <div ref="c-autocomplete" class="c-autocomplete">
    <div class="c-autocomplete__batch-container">
      <button v-for="item in batches" :key="item" class="c-autocomplete__batch">
        {{ item.type + ' : ' + item.value }}
      </button>
    </div>
    <input
      v-model="label"
      :name="name + '-label'"
      class="c-autocomplete__input"
      :disabled="isDisabled"
      type="text"
      @keyup="manualChange"
    />
    <div
      :class="{
        'c-autocomplete__option-container--loading': labelChanged,
      }"
    >
      <div v-for="result in autoCompleteResults" :key="result.name">
        <button
          v-if="result.type === 'categories'"
          class="auto-complete-button"
          @click="emitSelect(result.name, result.type)"
        >
          {{ result.name }}
        </button>

        <button
          v-if="result.type === 'authors'"
          class="auto-complete-button"
          @click="emitSelect(result.name)"
        >
          {{ result.name }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Autocomplete',
  props: {
    disabled: {
      type: Boolean,
      default: false,
    },
    name: {
      type: String,
      required: true,
    },
    loading: {
      type: Boolean,
      default: true,
    },
    initLabel: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      label: '',
      timeout: null,
      labelChanged: false,
    };
  },
  computed: {
    autoCompleteResults() {
      return this.$store.state.autoCompleteResults;
    },
    curValue() {
      return this.value;
    },
    isDisabled() {
      return this.disabled;
    },
    batches() {
      return this.$store.state.batches;
    },
  },
  watch: {
    loading(val) {
      if (!val) {
        this.labelChanged = false;
      }
    },
    initLabel: {
      immediate: true,
      handler(label) {
        if (label) {
          this.label = label;
        }
      },
    },
  },
  created() {},
  methods: {
    manualChange() {
      clearTimeout(this.timeout);
      this.labelChanged = true;

      this.timeout = setTimeout(this.emitChange, 1000);
    },
    emitChange() {
      this.$store.dispatch('getAutoCompleteResults', this.label);
    },
    emitSelect(value, type) {
      console.log(value, type);
      this.$store.dispatch('addBatch', { value, type });
      this.$emit('select', value);
    },
  },
};
</script>

<style></style>
