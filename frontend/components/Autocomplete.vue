<template>
  <div ref="c-autocomplete" class="c-autocomplete">
    <label class="c-autocomplete__label" for="comic-search">{{ name }}: </label>
    <div class="c-autocomplete__batch-container">
      <button
        v-for="valueItem in curValue"
        :key="valueItem.value"
        class="c-autocomplete__batch"
        :data-value="valueItem.value"
      >
        {{ valueItem.label }}
      </button>
    </div>
    <input
      id="comic-search"
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
      <button
        v-for="result in autoCompleteResults"
        :key="result.name"
        class="auto-complete-button"
      >
        {{ result.name }}
      </button>
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
  methods: {
    manualChange() {
      clearTimeout(this.timeout);
      this.labelChanged = true;

      this.$emit('select', null);
      this.timeout = setTimeout(this.emitChange, 1000);
    },
    emitChange() {
      this.$store.dispatch('getAutoCompleteResults', this.label);
    },
  },
};
</script>

<style></style>
