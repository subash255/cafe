<!-- Modern Admin Table Component -->
<style>
    .admin-table-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 2px;
        margin-bottom: 2rem;
    }
    
    .admin-table-inner {
        background: white;
        border-radius: 18px;
        overflow: visible;
    }
    
    .table-header {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 2px solid #e2e8f0;
    }
    
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        padding: 1.25rem 1.5rem;
        text-align: left;
        font-weight: 700;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 3px solid #e5e7eb;
        position: relative;
    }
    
    .modern-table thead th:first-child {
        border-top-left-radius: 16px;
    }
    
    .modern-table thead th:last-child {
        border-top-right-radius: 16px;
    }
    
    .modern-table tbody td {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        background: white;
        transition: all 0.3s ease;
        overflow: visible;
        position: relative;
    }
    
    .modern-table tbody tr:hover td {
        background: #f8fafc;
        transform: scale(1.005);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 16px;
    }
    
    .modern-table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 16px;
    }
    
    .search-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .search-input {
        width: 100%;
        padding: 0.875rem 1rem 0.875rem 3rem;
        border: 2px solid transparent;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        font-size: 0.875rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1), 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .search-icon {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-size: 1.125rem;
    }
    
    .action-button {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }
    
    .action-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .btn-view {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
    }
    
    .btn-view:hover {
        background: linear-gradient(135deg, #bfdbfe 0%, #93c5fd 100%);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .btn-edit:hover {
        background: linear-gradient(135deg, #fde68a 0%, #fcd34d 100%);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #fecaca 0%, #fca5a5 100%);
        color: #991b1b;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #fca5a5 0%, #f87171 100%);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .status-active {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #065f46;
    }
    
    .status-inactive {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        color: #991b1b;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        color: #92400e;
    }
    
    .no-data {
        text-align: center;
        padding: 3rem 2rem;
        color: #6b7280;
    }
    
    .no-data i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }
    
    /* Enhanced Modal Styling with Better Sizing */
    .modern-modal {
        background: rgba(0, 0, 0, 0.6);
        backdrop-filter: blur(8px);
        padding: 1rem;
    }
    
    .modal-content {
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e2e8f0;
        max-height: 90vh;
        overflow-y: auto;
        width: 100%;
        max-width: 90vw;
    }
    
    .modern-input {
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        transition: all 0.3s ease;
        background: #f8fafc;
    }
    
    .modern-input:focus {
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .modern-button {
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .file-upload-area {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        transition: all 0.3s ease;
        cursor: pointer;
        background: #f9fafb;
    }
    
    .file-upload-area:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }
    
    .modal-hidden {
        display: none !important;
    }
    
    .modal-visible {
        display: flex !important;
        align-items: center;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .modal-content {
            max-width: 95vw;
            max-height: 95vh;
            margin: 1rem;
            padding: 1rem;
        }
        
        .modern-table thead {
            display: none;
        }
        
        .modern-table tbody td {
            display: block;
            text-align: left;
            border: none;
            padding: 0.75rem 1rem;
        }
        
        .modern-table tbody td:before {
            content: attr(data-label) ": ";
            font-weight: 600;
            color: #374151;
        }
        
    .modern-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: visible;
    }
    }
    
    @media (min-width: 769px) and (max-width: 1024px) {
        .modal-content {
            max-width: 85vw;
        }
    }
    
    @media (min-width: 1025px) {
        .modal-content {
            max-width: 70vw;
        }
    }
</style>
