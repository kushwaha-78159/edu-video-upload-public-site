// Load and display videos from server
let allVideos = [];
let currentSearch = '';

// Load videos on page load
document.addEventListener('DOMContentLoaded', () => {
    loadVideos();
    
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value.toLowerCase();
            displayVideos();
        });
    }
});

async function loadVideos() {
    try {
        const response = await fetch('get_videos.php');
        const videos = await response.json();
        
        if (videos && videos.length > 0) {
            allVideos = videos;
        } else {
            // Sample videos if no videos exist
            allVideos = [
                {
                    id: 1,
                    title: "Sample Video: How to Upload",
                    description: "Watch this video to learn how to upload your own content",
                    uploaderName: "EDUCAST Team",
                    category: "Other",
                    videoUrl: "",
                    thumbnail: "https://via.placeholder.com/400x225?text=Sample+Video",
                    views: 0,
                    date: new Date().toISOString(),
                    duration: "00:30"
                }
            ];
        }
        
        displayVideos();
    } catch (error) {
        console.error('Error loading videos:', error);
        displayVideos();
    }
}

function displayVideos() {
    const grid = document.getElementById('videosGrid');
    const countDiv = document.getElementById('videosCount');
    
    let filteredVideos = allVideos;
    
    if (currentSearch) {
        filteredVideos = allVideos.filter(video => 
            video.title.toLowerCase().includes(currentSearch) ||
            (video.description && video.description.toLowerCase().includes(currentSearch))
        );
    }
    
    if (countDiv) {
        countDiv.innerHTML = `${filteredVideos.length} video${filteredVideos.length !== 1 ? 's' : ''} found`;
    }
    
    if (filteredVideos.length === 0) {
        grid.innerHTML = '<div style="text-align: center; padding: 3rem;">No videos found. Be the first to <a href="upload.html" style="color: #ff8844;">upload a video!</a></div>';
        return;
    }
    
    grid.innerHTML = filteredVideos.map(video => `
        <div class="video-card" onclick="watchVideo(${video.id})">
            <div class="video-thumbnail">
                <img src="${video.thumbnail || 'https://via.placeholder.com/400x225?text=No+Thumbnail'}" alt="${video.title}">
                <span class="duration">${video.duration || '00:00'}</span>
            </div>
            <div class="video-info">
                <h3>${video.title.substring(0, 60)}</h3>
                <p class="uploader-name"><i class="fas fa-user"></i> ${video.uploaderName}</p>
                <p class="views"><i class="fas fa-eye"></i> ${formatNumber(video.views)} views</p>
            </div>
        </div>
    `).join('');
}

function formatNumber(num) {
    if (num >= 1000000) return (num/1000000).toFixed(1) + 'M';
    if (num >= 1000) return (num/1000).toFixed(1) + 'K';
    return num || 0;
}

function watchVideo(videoId) {
    window.location.href = `video-player.html?id=${videoId}`;
}