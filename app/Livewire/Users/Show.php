<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Models\LeaveRequest;
use Livewire\Component;

class Show extends Component
{
    public User $user;

    public function mount(User $user)
    {
        $this->user = $user->load(['company', 'department', 'leaveRequests.leaveType']);
    }

    public function toggleUserStatus()
    {
        $this->user->update([
            'is_active' => !$this->user->is_active,
            'employment_status' => $this->user->is_active ? 'inactive' : 'active'
        ]);

        $this->user->refresh();
        session()->flash('success', 'User status updated successfully.');
    }

    public function render()
    {
        // Get recent leave requests
        $recentLeaveRequests = $this->user->leaveRequests()
            ->with('leaveType')
            ->latest()
            ->take(5)
            ->get();

        // Get user statistics
        $stats = [
            'total_leave_requests' => $this->user->leaveRequests()->count(),
            'approved_leaves' => $this->user->leaveRequests()->where('status', 'approved')->count(),
            'pending_leaves' => $this->user->leaveRequests()->where('status', 'pending')->count(),
            'years_of_service' => $this->user->hire_date ?
                $this->user->hire_date->diffInYears(now()) : 0,
        ];

        return view('livewire.users.show', [
            'recentLeaveRequests' => $recentLeaveRequests,
            'stats' => $stats,
        ]);
    }
}
