<script setup lang="ts">
type EventPin = {
  id: number
  label: string
  x: number // percentage from left
  y: number // percentage from top
  count?: number
}

const pins: EventPin[] = [
  { id: 1, label: 'North America', x: 20, y: 45, count: 23 },
  { id: 2, label: 'South America', x: 30, y: 70, count: 12 },
  { id: 3, label: 'Europe', x: 48, y: 45, count: 35 },
  { id: 4, label: 'Asia', x: 75, y: 50, count: 19 },
  { id: 5, label: 'Africa', x: 55, y: 65, count: 8 },
]
</script>

<template>
  <div class="pixel-map">
    <div class="map-dots"></div>

    <button
      v-for="pin in pins"
      :key="pin.id"
      class="map-pin"
      :style="{ left: `${pin.x}%`, top: `${pin.y}%` }"
      :title="pin.label"
    >
      {{ pin.count ?? '' }}
    </button>
  </div>
</template>

<style scoped>
.pixel-map {
  position: relative;
  width: 100%;
  aspect-ratio: 2 / 1;
  overflow: hidden;
  min-height: 500px;
}

.map-dots {
  width: 100%;
  height: 100%;

  background-image: radial-gradient(
    currentColor 1.4px,
    transparent 1.4px
  );
  background-size: 6px 6px;

  color: #1e73ff;

  mask-image: url('../../images/world.svg');
  mask-size: contain;
  mask-repeat: no-repeat;
  mask-position: center;

  -webkit-mask-image: url('../../images/world.svg');
  -webkit-mask-size: contain;
  -webkit-mask-repeat: no-repeat;
  -webkit-mask-position: center;
}

.map-pin {
  position: absolute;
  transform: translate(-50%, -50%);
  width: 38px;
  height: 38px;
  border-radius: 999px;
  border: 2px solid white;
  background: #1e73ff;
  color: white;
  font-weight: 700;
  box-shadow: 0 0 0 6px rgb(30 115 255 / 15%);
  cursor: pointer;
}

.dark .map-dots {
  color: #22d3ee;
  opacity: 0.55;
}

.dark .map-pin {
  background: #22d3ee;
  color: #061018;
  box-shadow: 0 0 18px rgb(34 211 238 / 45%);
}
</style>
