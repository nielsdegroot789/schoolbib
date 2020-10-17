<template>
  <div ref="c-autocomplete" class="c-autocomplete">
    <label class="c-autocomplete__label" for="comic-search">{{ name }}: </label>
    <div class="c-autocomplete__batch-container">
      <button
        v-for="valueItem in curValue"
        :key="valueItem.value"
        class="c-autocomplete__batch"
        :data-value="valueItem.value"
        @click="removeItem(valueItem.value)"
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
      @blur="blur"
      @keyup="manualChange"
    />
    <div
      :class="{
        'c-autocomplete__option-container': true,
        'c-autocomplete__option-container--empty':
          !labelChanged && options.length === 0,
        'c-autocomplete__option-container--loading': labelChanged,
      }"
    >
      <button
        v-for="option in optionList"
        :key="'comic_option_' + option.value"
        :class="{
          'c-autocomplete__option': true,
          'c-autocomplete__option--disabled': optionIsSelected(option.value),
        }"
        :disabled="optionIsSelected(option.value)"
        type="button"
        @click.prevent="selectOption(option.label, option.value)"
        @keyup.enter="selectOption(option.label, option.value)"
      >
        {{ option.label }}
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
    value: {
      type: Array,
      default() {
        return [];
      },
    },
    options: {
      type: Array,
      default() {
        return [];
      },
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
    optionList() {
      return this.options;
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
    removeItem(value) {
      this.$emit('remove', value);
    },
    manualChange() {
      clearTimeout(this.timeout);
      this.labelChanged = true;

      this.$emit('select', null);
      this.timeout = setTimeout(this.emitChange, 1000);
    },
    emitChange() {
      if (this.label.length === 0) {
        this.labelChanged = false;
        this.$emit('select', null);
        return;
      }
      this.$emit('change', this.label);
    },
  },
};
</script>

<style></style>
