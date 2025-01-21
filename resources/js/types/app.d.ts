declare namespace App {
    export type NotificationType =  'success' | 'error' | 'warning' | 'info' | 'default';

    export type NotificationData = {
        type: NotifcationType;
        body: string;
    }

    export type SharedData = {
        location: string;
        notification: NotificationData | null;
        user: unknown
    }
}
