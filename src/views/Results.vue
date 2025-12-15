<template>
  <div class="results-container">
    <h1>Résultats</h1>
    
    <div v-if="loading" class="loading">Chargement...</div>
    
    <div v-else-if="error" class="error">{{ error }}</div>
    
    <div v-else class="results">
      <div class="result-bar">
        <div class="label">
          <span class="vote-label">OUI</span>
          <span class="count">{{ results.oui }} vote{{ results.oui > 1 ? 's' : '' }}</span>
        </div>
        <div class="bar">
          <div class="fill fill-yes" :style="{ width: percentYes + '%' }"></div>
        </div>
        <span class="percent">{{ percentYes.toFixed(1) }}%</span>
      </div>
      
      <div class="result-bar">
        <div class="label">
          <span class="vote-label">NON</span>
          <span class="count">{{ results.non }} vote{{ results.non > 1 ? 's' : '' }}</span>
        </div>
        <div class="bar">
          <div class="fill fill-no" :style="{ width: percentNo + '%' }"></div>
        </div>
        <span class="percent">{{ percentNo.toFixed(1) }}%</span>
      </div>
      
      <div class="total">
        Total : {{ results.total }} vote{{ results.total > 1 ? 's' : '' }}
      </div>
      
      <button @click="refreshResults" class="btn refresh-btn">🔄 Actualiser</button>
    </div>
    
    <router-link to="/" class="back-link">← Retour au vote</router-link>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'

const API_URL = 'http://localhost/vote'

const results = ref({
  oui: 0,
  non: 0,
  total: 0
})

const loading = ref(true)
const error = ref('')

const percentYes = computed(() => {
  if (results.value.total === 0) return 0
  return (results.value.oui / results.value.total) * 100
})

const percentNo = computed(() => {
  if (results.value.total === 0) return 0
  return (results.value.non / results.value.total) * 100
})

const fetchResults = async () => {
  loading.value = true
  error.value = ''
  
  try {
    const response = await fetch(`${API_URL}/results.php`)
    const data = await response.json()
    
    if (response.ok) {
      results.value = data
    } else {
      error.value = data.error || 'Erreur lors du chargement des résultats'
    }
  } catch (e) {
    error.value = 'Erreur de connexion au serveur'
    console.error('Erreur:', e)
  } finally {
    loading.value = false
  }
}

const refreshResults = () => {
  fetchResults()
}

onMounted(() => {
  fetchResults()
})
</script>

<style scoped>
.results-container {
  max-width: 800px;
  margin: 50px auto;
  padding: 40px;
  background: #f5f5f5;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

h1 {
  text-align: center;
  font-size: 2.5em;
  margin-bottom: 40px;
  color: #333;
}

.loading {
  text-align: center;
  font-size: 1.2em;
  color: #666;
  padding: 40px;
}

.error {
  color: #d32f2f;
  background: #ffebee;
  padding: 20px;
  border-radius: 5px;
  text-align: center;
}

.results {
  margin-top: 30px;
}

.result-bar {
  margin-bottom: 30px;
  padding: 20px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.label {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
  font-weight: bold;
}

.vote-label {
  font-size: 1.3em;
  color: #333;
}

.count {
  color: #666;
  font-size: 1em;
}

.bar {
  height: 40px;
  background: #e0e0e0;
  border-radius: 20px;
  overflow: hidden;
  margin-bottom: 10px;
}

.fill {
  height: 100%;
  transition: width 0.5s ease;
  border-radius: 20px;
}

.fill-yes {
  background: linear-gradient(90deg, #4CAF50, #81C784);
}

.fill-no {
  background: linear-gradient(90deg, #f44336, #e57373);
}

.percent {
  display: block;
  text-align: right;
  font-size: 1.2em;
  font-weight: bold;
  color: #555;
}

.total {
  text-align: center;
  font-size: 1.3em;
  margin: 30px 0;
  padding: 15px;
  background: white;
  border-radius: 8px;
  color: #333;
  font-weight: bold;
}

.refresh-btn {
  display: block;
  margin: 30px auto;
  padding: 12px 30px;
  background: #2196F3;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1.1em;
  cursor: pointer;
  transition: all 0.3s;
}

.refresh-btn:hover {
  background: #1976D2;
  transform: scale(1.05);
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 30px;
  color: #666;
  text-decoration: none;
}

.back-link:hover {
  color: #333;
  text-decoration: underline;
}
</style>