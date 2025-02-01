declare namespace App {
    export type Country = {
        id: number;
        code: string;
        name: string;
        prefix: string;
        created_at: string;
        updated_at: string;
    }

    export type Event = {
        id: number;
        title: string;
        slug: string;
        start_date: string;
        end_date: string;
        blurb: string | null;
        website: string | null;
        image_url: string | null;
        price_on_door: number | null;
        price_in_adv: number | null;
        currency: string | null;
        alcohol: boolean | null;
        smoking: boolean | null;
        showers: boolean | null;
        seats: number | null;
        network_mbps: number | null;
        internet_mbps: number | null;
        is_published: boolean;
        creator?: User;
        organiser?: Organiser;
        venue?: Venue;
        reviews?: EventReview[];
        created_at: string;
        updated_at: string;
    }

    export type EventReview = {
        id: number;
        event?: Event;
        user?: User;
        rating_venue: number;
        rating_vfm: number;
        rating_activities: number;
        created_at: string;
        updated_at: string;
    }

    export type NotificationType =  'success' | 'error' | 'warning' | 'info' | 'default';

    export type NotificationData = {
        type: NotifcationType;
        body: string;
    }

    export type Organiser = {
        id: number;
        title: string;
        slug: string;
        website: string | null;
        steam_group_url: string | null;
        blurb: string | null;
        is_published: boolean;
        use_favicon: boolean;
        assumed_stale_at: string | null;
        events?: Event[];
        users?: User[];
        requests?: OrganiserJoinRequest[];
        created_at: string;
        updated_at: string;
    }

    export type OrganiserJoinRequest = {
        id: number;
        user: User;
        organiser: Organiser;
        comments: string | null;
        created_at: string;
        updated_at: string;
    }

    export type PageResource<T> = {
        data: T[];
        meta: PageMeta;
    }

    export type PageMeta = {
        current_page: number;
        from: number;
        last_page: number;
        per_page: number;
        to: number;
        total: number;
        path: string;
        links: {
          [key: number]: { url: string | null; label: string; active: boolean };
        }
    }

    export type SharedData = {
        location: string;
        notification: NotificationData | null;
        socials: {
            discord: boolean;
            twitch: boolean;
        },
        isImpersonating: boolean;
        isAdmin: boolean;
        user: User | null;
    }

    export type TextInputOptions = {
        enterSubmit?: boolean;
        tabSubmit?: boolean;
        openMenu?: 'open' | 'toggle' | boolean;
        rangeSeparator?: string;
        selectOnFocus?: boolean;
        format?: string | string[] | ((value: string) => Date | null);
        escClose?: boolean;
    }

    export type User = {
        id: number;
        username: string;
        email?: string;
        date_format?: string;
        timezone?: string;
        twitch_id?: string | null;
        discord_id?: string | null;
        ip?: string | null;
        profile_photo: string;
        email_verified_at: string | null;
        password_changed_at: string | null;
        last_active_at: string | null;
        created_at: string;
        updated_at: string;
    }

    export type Venue = {
        id: number;
        title: string;
        country?: Country;
        lat: number;
        lng: number;
        events?: Event[];
        created_at: string;
        updated_at: string;
    }
}
