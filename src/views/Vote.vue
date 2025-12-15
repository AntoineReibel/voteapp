<template>
  <div class="vote-container">
    <h1>Votez !</h1>
    
    <div v-if="hasVoted" class="already-voted">
      <p>✓ Vous avez déjà voté</p>
      <router-link to="/results" class="btn">Voir les résultats</router-link>
    </div>
    
    <div v-else-if="voted" class="success">
      <p>✓ Merci, votre vote a été enregistré !</p>
      <router-link to="/results" class="btn">Voir les résultats</router-link>
    </div>
    
    <div v-else class="vote-buttons">
      <button @click="submitVote(1)" class="btn btn-yes" :disabled="loading">
        {{ loading ? 'Envoi...' : 'OUI' }}
      </button>
      <button @click="submitVote(0)" class="btn btn-no" :disabled="loading">
        {{ loading ? 'Envoi...' : 'NON' }}
      </button>
    </div>
    
    <div v-if="error" class="error">{{ error }}</div>
    
    <router-link to="/results" class="results-link">Voir les résultats</router-link>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const API_URL = 'http://localhost/vote'

const hasVoted = ref(false)
const voted = ref(false)
const loading = ref(false)
const error = ref('')

const checkIfVoted = async () => {
  try {
    const response = await fetch(`${API_URL}/has-voted.php`)
    const data = await response.json()
    hasVoted.value = data.hasVoted
  } catch (e) {
    console.error('Erreur:', e)
  }
}

const submitVote = async (vote) => {
  loading.value = true
  error.value = ''
  
  try {
    const response = await fetch(`${API_URL}/vote.php`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ vote })
    })
    
    const data = await response.json()
    
    if (response.ok) {
      voted.value = true
    } else {
      error.value = data.error || 'Une erreur est survenue'
    }
  } catch (e) {
    error.value = 'Erreur de connexion au serveur'
    console.error('Erreur:', e)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  checkIfVoted()
})
</script>

<style scoped>
.vote-container {
  max-width: 600px;
  margin: 50px auto;
  padding: 40px;
  text-align: center;
  background: #f5f5f5;
  border-radius: 10px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

h1 {
  font-size: 2.5em;
  margin-bottom: 40px;
  color: #333;
}

.vote-buttons {
  display: flex;
  gap: 20px;
  justify-content: center;
  margin: 40px 0;
}

.btn {
  padding: 20px 60px;
  font-size: 1.5em;
  font-weight: bold;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s;
  text-decoration: none;
  display: inline-block;
}

.btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-yes {
  background: #4CAF50;
  color: white;
}

.btn-yes:hover:not(:disabled) {
  background: #45a049;
  transform: scale(1.05);
}

.btn-no {
  background: #f44336;
  color: white;
}

.btn-no:hover:not(:disabled) {
  background: #da190b;
  transform: scale(1.05);
}

.already-voted,
.success {
  padding: 30px;
  background: #e3f2fd;
  border-radius: 8px;
  margin: 20px 0;
}

.already-voted p,
.success p {
  font-size: 1.3em;
  color: #1976d2;
  margin-bottom: 20px;
}

.already-voted .btn,
.success .btn {
  background: #2196F3;
  color: white;
  padding: 15px 40px;
  font-size: 1.1em;
}

.error {
  color: #d32f2f;
  margin-top: 20px;
  padding: 15px;
  background: #ffebee;
  border-radius: 5px;
}

.results-link {
  display: inline-block;
  margin-top: 30px;
  color: #666;
  text-decoration: underline;
}

.results-link:hover {
  color: #333;
}
</style>