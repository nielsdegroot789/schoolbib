<template>
  <div ref="container-autocomplete" class="container-autocomplete">
    <label class="c-autocomplete__label" for="search">Categories: </label>
    <div class="c-autocomplete__batch-container">
      <button
        v-for="valueItem in curValue"
        :key="valueItem.value"
        class="container-autocomplete-batch"
        :data-value="valueItem.value"
        @click="removeItem(valueItem.value)"
      >
        {{ valueItem.label }}
      </button>
    </div>
    <input
      id="filter-search"
      v-model="label"
      :name="name + '-label'"
      class="container-autocomplete-input"
      :disabled="isDisabled"
      type="text"
      @blur="blur"
      @keyup="manualChange"
    />
    <div
      :class="{
        'container-autocomplete-option-container': true,
        'container-autocomplete-option-container--empty':
          !labelChanged && options.length === 0,
        'container-autocomplete-option-container--loading': labelChanged,
      }"
    >
      <button
        v-for="option in optionList"
        :key="'comic_option_' + option.value"
        :class="{
          'container-autocomplete__option': true,
          'container-autocomplete__option--disabled': optionIsSelected(
            option.value,
          ),
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
  methods: {
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
