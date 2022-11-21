const playButton = document.querySelector("#playButton")
const playButtonIcon = document.querySelector("#playButtonIcon")
const waveform = document.querySelector("#waveform")
const volumeSlider = document.querySelector("#volumeSlider")
const currentTime = document.querySelector("#currentTime")
const totalDuration = document.querySelector("#totalDuration")

/**

 * Initialize Wavesurfer

 * @returns a new Wavesurfer instance

 */
const initializeWavesurfer = () => {
    return WaveSurfer.create({
      container: "#waveform",
      responsive: true,
      height: 80,
      waveColor: "orange",
      progressColor: "white",
    })
}

function submitCopy() {
  /* Get the text field */
  var copyText = document.getElementById("submit-copy");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /* For mobile devices */

   /* Copy the text inside the text field */
  navigator.clipboard.writeText(copyText.value);

  /* Alert the copied text */
  alert("Link Coppied In Clipboard: " + copyText.value);
} 

/**

 * Toggle play button

 */
const togglePlay = () => {
    wavesurfer.playPause()
    const isPlaying = wavesurfer.isPlaying()
  
    if (isPlaying) {
      playButtonIcon.className = "fa fa-circle-pause"
    } else {
      playButtonIcon.className = "fa fa-circle-play"
    }
}

/**

 * Handles changing the volume slider input

 * @param {event} e

 */
const handleVolumeChange = e => {

    // Set volume as input value divided by 100
    // NB: Wavesurfer only excepts volume value between 0 - 1
    const volume = e.target.value / 100

    wavesurfer.setVolume(volume)
  
    // Save the value to local storage so it persists between page reloads
    localStorage.setItem("audio-player-volume", volume)
}

const setVolumeFromLocalStorage = () => {

    // Retrieves the volume from local storage, or falls back to default value of 50
    const volume = localStorage.getItem("audio-player-volume") * 100 || 50
    volumeSlider.value = volume
}

/**

 * Formats time as HH:MM:SS

 * @param {number} seconds

 * @returns time as HH:MM:SS

 */
const formatTimecode = seconds => {
    return new Date(seconds * 1000).toISOString().substr(11, 8)
}

const toggleMute = () => {

  wavesurfer.toggleMute()
  const isMuted = wavesurfer.getMute()

  if (isMuted) {
    volumeIcon.className = "fa fa-volume-mute"
    volumeSlider.disabled = true
  } else {
    volumeSlider.disabled = false
    volumeIcon.className = "fa fa-volume-high"
  }
}

// Create a new instance and load the wavesurfer
const wavesurfer = initializeWavesurfer()
wavesurfer.load('songs/singles/'+audio);

// Javascript Event listeners

window.addEventListener("load", setVolumeFromLocalStorage)

playButton.addEventListener("click", togglePlay)
volumeIcon.addEventListener("click", toggleMute)
volumeSlider.addEventListener("input", handleVolumeChange)

// Wavesurfer event listeners
wavesurfer.on("ready", () => {

    // Set wavesurfer volume
    wavesurfer.setVolume(volumeSlider.value / 100)
  
    // Set audio track total duration
    const duration = wavesurfer.getDuration()
    totalDuration.innerHTML = formatTimecode(duration)
})
  
// Sets the timecode current timestamp as audio plays
wavesurfer.on("audioprocess", () => {
    const time = wavesurfer.getCurrentTime()
    currentTime.innerHTML = formatTimecode(time)
})
  
// Resets the play button icon after audio ends
wavesurfer.on("finish", () => {
    playButtonIcon.className = "fa fa-circle-play"
})
