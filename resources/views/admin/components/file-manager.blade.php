<!-- File Manager Modal -->
<div class="modal fade" id="fileManagerModal" tabindex="-1" aria-labelledby="fileManagerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileManagerModalLabel">
                    <i class="ph ph-folder"></i> File Manager
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Toolbar -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" id="btnBack" class="btn btn-sm btn-outline-secondary" disabled>
                            <i class="ph ph-arrow-left"></i> Back
                        </button>
                        <span id="currentPath" class="text-muted small">/ uploads</span>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" id="btnUpload" class="btn btn-sm btn-primary">
                            <i class="ph ph-upload"></i> Upload
                        </button>
                        <button type="button" id="btnCreateFolder" class="btn btn-sm btn-success">
                            <i class="ph ph-folder-plus"></i> New Folder
                        </button>
                        <button type="button" id="btnRefresh" class="btn btn-sm btn-outline-secondary">
                            <i class="ph ph-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                </div>

                <!-- File Grid -->
                <div id="fileGrid" class="row g-3" style="max-height: 400px; overflow-y: auto;">
                    <!-- Files will be loaded here -->
                </div>

                <!-- Loading -->
                <div id="loadingFiles" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="text-center py-5" style="display: none;">
                    <i class="ph ph-folder-open" style="font-size: 48px; color: #ccc;"></i>
                    <p class="text-muted mt-2">Folder kosong</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="me-auto">
                    <span id="selectedCount" class="text-muted small">0 file dipilih</span>
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="btnSelectFiles" class="btn btn-primary" disabled>Select Files</button>
            </div>
        </div>
    </div>
</div>

<!-- Hidden Upload Input -->
<input type="file" id="fileManagerUpload" multiple accept="image/*" style="display: none;">

<style>
.file-item {
    cursor: pointer;
    transition: all 0.2s;
    border: 2px solid transparent;
}

.file-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.file-item.selected {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.1);
}

.file-item .card-img-top {
    height: 120px;
    object-fit: cover;
}

.folder-item {
    background: linear-gradient(45deg, #f8f9fa, #e9ecef);
    border: 1px dashed #dee2e6;
}

.folder-item:hover {
    background: linear-gradient(45deg, #e9ecef, #dee2e6);
}

.file-actions {
    position: absolute;
    top: 5px;
    right: 5px;
    opacity: 0;
    transition: opacity 0.2s;
}

.file-item:hover .file-actions {
    opacity: 1;
}
</style>

<script>
class FileManager {
    constructor() {
        this.currentPath = '';
        this.selectedFiles = [];
        this.isMultiSelect = true;
        this.callback = null;
        
        this.init();
    }
    
    init() {
        // Event listeners
        $('#btnBack').on('click', () => this.goBack());
        $('#btnUpload').on('click', () => this.showUpload());
        $('#btnCreateFolder').on('click', () => this.showCreateFolder());
        $('#btnRefresh').on('click', () => this.loadFiles());
        $('#btnSelectFiles').on('click', () => this.selectFiles());
        
        // Upload handler
        $('#fileManagerUpload').on('change', (e) => this.handleUpload(e));
        
        // Modal events
        $('#fileManagerModal').on('shown.bs.modal', () => this.loadFiles());
        $('#fileManagerModal').on('hidden.bs.modal', () => this.reset());
    }
    
    open(options = {}) {
        this.isMultiSelect = options.multiSelect !== false;
        this.callback = options.callback || null;
        this.currentPath = options.path || '';
        
        $('#fileManagerModal').modal('show');
    }
    
    reset() {
        this.currentPath = '';
        this.selectedFiles = [];
        this.updateSelectedCount();
        $('#btnSelectFiles').prop('disabled', true);
    }
    
    async loadFiles() {
        $('#loadingFiles').show();
        $('#fileGrid').hide();
        $('#emptyState').hide();
        
        try {
            const response = await $.ajax({
                url: '/admin/file-manager',
                method: 'GET',
                data: { 
                    path: this.currentPath,
                    type: 'image'
                }
            });
            
            if (response.success) {
                this.renderFiles(response.items);
                this.updateCurrentPath();
                this.updateBackButton();
            }
        } catch (error) {
            console.error('Error loading files:', error);
            alert('Error loading files');
        } finally {
            $('#loadingFiles').hide();
        }
    }
    
    renderFiles(items) {
        const grid = $('#fileGrid');
        grid.empty();
        
        if (items.length === 0) {
            $('#emptyState').show();
            $('#fileGrid').hide();
            return;
        }
        
        $('#fileGrid').show();
        
        items.forEach(item => {
            const col = $('<div class="col-lg-2 col-md-3 col-sm-4 col-6"></div>');
            
            if (item.type === 'folder') {
                col.html(this.renderFolder(item));
            } else if (item.is_image) {
                col.html(this.renderImage(item));
            }
            
            grid.append(col);
        });
    }
    
    renderFolder(folder) {
        return `
            <div class="card file-item folder-item h-100" data-type="folder" data-path="${folder.path}">
                <div class="card-body text-center d-flex flex-column justify-content-center">
                    <i class="ph ph-folder" style="font-size: 48px; color: #6c757d;"></i>
                    <h6 class="card-title mt-2 mb-0 small text-truncate" title="${folder.name}">${folder.name}</h6>
                </div>
            </div>
        `;
    }
    
    renderImage(file) {
        return `
            <div class="card file-item h-100" data-type="file" data-path="${file.path}" data-url="${file.url}">
                <div class="position-relative">
                    <img src="${file.url}" class="card-img-top" alt="${file.name}">
                    <div class="file-actions">
                        <button class="btn btn-sm btn-danger" onclick="fileManager.deleteFile('${file.path}')">
                            <i class="ph ph-trash"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-2">
                    <h6 class="card-title mb-1 small text-truncate" title="${file.name}">${file.name}</h6>
                    <small class="text-muted">${this.formatFileSize(file.size)}</small>
                </div>
            </div>
        `;
    }
    
    async deleteFile(path) {
        if (!confirm('Yakin ingin menghapus file ini?')) return;
        
        try {
            const response = await $.ajax({
                url: '/admin/file-manager/delete',
                method: 'DELETE',
                data: { path: path },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            if (response.success) {
                this.loadFiles();
                alert(response.message);
            }
        } catch (error) {
            console.error('Error deleting file:', error);
            alert('Error deleting file');
        }
    }
    
    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    updateCurrentPath() {
        const pathDisplay = this.currentPath || 'uploads';
        $('#currentPath').text('/ ' + pathDisplay);
    }
    
    updateBackButton() {
        $('#btnBack').prop('disabled', !this.currentPath);
    }
    
    updateSelectedCount() {
        const count = this.selectedFiles.length;
        $('#selectedCount').text(count + ' file dipilih');
        $('#btnSelectFiles').prop('disabled', count === 0);
    }
    
    goBack() {
        if (!this.currentPath) return;
        
        const pathParts = this.currentPath.split('/');
        pathParts.pop();
        this.currentPath = pathParts.join('/');
        this.loadFiles();
    }
    
    showUpload() {
        $('#fileManagerUpload').click();
    }
    
    async handleUpload(e) {
        const files = e.target.files;
        if (files.length === 0) return;
        
        const formData = new FormData();
        Array.from(files).forEach(file => {
            formData.append('files[]', file);
        });
        formData.append('path', this.currentPath);
        
        try {
            const response = await $.ajax({
                url: '/admin/file-manager/upload',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            if (response.success) {
                this.loadFiles();
                alert(response.message);
                e.target.value = ''; // Reset input
            }
        } catch (error) {
            console.error('Error uploading files:', error);
            alert('Error uploading files');
        }
    }
    
    async showCreateFolder() {
        const folderName = prompt('Nama folder:');
        if (!folderName) return;
        
        try {
            const response = await $.ajax({
                url: '/admin/file-manager/create-folder',
                method: 'POST',
                data: { 
                    name: folderName,
                    path: this.currentPath
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            
            if (response.success) {
                this.loadFiles();
                alert(response.message);
            } else {
                alert(response.message);
            }
        } catch (error) {
            console.error('Error creating folder:', error);
            alert('Error creating folder');
        }
    }
    
    selectFiles() {
        if (this.callback) {
            this.callback(this.selectedFiles);
        }
        $('#fileManagerModal').modal('hide');
    }
}

// Initialize file manager
const fileManager = new FileManager();

// Handle file/folder clicks
$(document).on('click', '.file-item', function(e) {
    e.preventDefault();
    
    const $this = $(this);
    const type = $this.data('type');
    
    if (type === 'folder') {
        fileManager.currentPath = $this.data('path');
        fileManager.loadFiles();
    } else if (type === 'file') {
        // Toggle selection
        if ($this.hasClass('selected')) {
            $this.removeClass('selected');
            fileManager.selectedFiles = fileManager.selectedFiles.filter(f => f.path !== $this.data('path'));
        } else {
            if (!fileManager.isMultiSelect) {
                $('.file-item').removeClass('selected');
                fileManager.selectedFiles = [];
            }
            $this.addClass('selected');
            fileManager.selectedFiles.push({
                path: $this.data('path'),
                url: $this.data('url'),
                name: $this.find('.card-title').text()
            });
        }
        
        fileManager.updateSelectedCount();
    }
});
</script>