<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\MemberStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Requests\User\UserRoleUpdateRequest;
use App\Http\Resources\UserResource;
use App\Mail\Subscription;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\UnauthorizedException;
use App\Http\Resources\PermissionResource;
use App\Gallery;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['store']);
    }

    /**
     * Display a listing of the users.
     *
     * @group Users
     *
     * @bodyParam firstname string the user's first name
     * @bodyParam last_name string the user's last name
     * @bodyParam name string the user's nickname
     * @bodyParam email string the user's email
     * @bodyParam role string the user's role
     * @bodyParam per_page int the number of desired users per page
     *
     * @param UserIndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(UserIndexRequest $request)
    {
        $data = $request->only(['firstname', 'lastname', 'name', 'email', 'role', 'per_page']);

        $user = User
            ::when(isset($data['firstname']), function ($user) use ($data) {
                return $user->orWhere('firstname', 'like', '%' . $data['firstname'] . '%');
            })
            ->when(isset($data['firstname']), function ($user) use ($data) {
                return $user->orWhere('firstname', 'like', '%' . $data['firstname'] . '%');
            })
            ->when(isset($data['lastname']), function ($user) use ($data) {
                return $user->orWhere('lastname', 'like', '%' . $data['lastname'] . '%');
            })
            ->when(isset($data['name']), function ($user) use ($data) {
                return $user->orWhere('name', 'like', '%' . $data['name'] . '%');
            })
            ->when(isset($data['email']), function ($user) use ($data) {
                return $user->orWhere('email', 'like', '%' . $data['email'] . '%');
            })
            ->when(isset($data['role']), function ($user) use ($data) {
                return $user->orWhere('role', 'like', $data['role']);
            })
            ->where('gallery_id', $request->user()->gallery->id);

        $per_page = 25;
        if (isset($data['per_page'])) {
            $per_page = min(1000, $data['per_page']);
        }
        return UserResource::collection($user->paginate($per_page));
    }

    /**
     * Store a newly created user in storage.
     *
     * @group Users
     *
     * @bodyParam firstname string the user's first name
     * @bodyParam last_name string the user's last name
     * @bodyParam name string the user's nickname
     * @bodyParam email string the user's email
     * @bodyParam password string the user's encrypted password
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->only(['firstname', 'lastname', 'name', 'email', 'password']);

        $gallery = Gallery::newModelInstance();
        $gallery->save();

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'admin';

        $user = $gallery->users()->create($data);
        $user->assignRole('admin');

        /*        Mail::send('email.subscription', ['user' => $user], function ($m) use ($user) {
                    $m->to($user->email, $user->name)->subject('Welcome to ThyArt');
                });*/

        return new UserResource($user);
    }


    /**
     * Store a newly created user in storage.
     * @group Users
     *
     * @bodyParam firstname string the user's first name
     * @bodyParam last_name string the user's last name
     * @bodyParam name string the user's nickname
     * @bodyParam email string the user's email
     * @bodyParam password string the user's encrypted password
     * @bodyParam role string the user's role
     *
     * @param MemberStoreRequest $request
     * @return UserResource
     */
    public function storeMember(MemberStoreRequest $request)
    {
        $data = $request->only(['firstname', 'lastname', 'name', 'email', 'password', 'role']);

        $passwd = $data['password'];

        $data['password'] = bcrypt($data['password']);
        $data['gallery_id'] = $request->user()->galleryId;
        $data['role'] = (isset($data['role'])) ? $data['role'] : 'member';

        $user = $request->user()->gallery->users()->create($data);
        $user->assignRole($data['role']);

        Mail::send('email.subscriptionMember', ['user' => $user, 'passwd' => $passwd], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Welcome to ThyArt');
        });

        return new UserResource($user);
    }


    /**
     * Display the specified user.
     *
     * @group Users
     *
     * @queryParam user User the user to show
     *
     * @param  \App\User  $user
     * @return UserResource
     */
    public function show(User $user)
    {
        Mail::send('email.subscriptionMember', ['user' => $user, 'passwd' => "Nik"], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Welcome to ThyArt');
        });

        if ($user->gallery->id != request()->user()->gallery->id) {
            throw new UnauthorizedException('That member doesn\'t work in your gallery.');
        }
        return new UserResource($user);
    }

    /**
     * Display the specified user by auth token.
     *
     * @group Users
     *
     * @return UserResource
     */
    public function showByToken()
    {
        return new UserResource(request()->user());
    }

    /**
     * Display a listing of the users.
     * @group Users
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getOwnPermissions()
    {
        return PermissionResource::collection(request()->user()->getAllPermissions());
    }

    /**
     * @group Users
    **/
    public function getUserPermissions(User $user)
    {
        return PermissionResource::collection($user->getAllPermissions());
    }

    /**
     * Update the specified user in storage.
     *
     * @group Users
     *
     * @bodyParam role string the user's new role
     *
     * @queryParam user User the user to be modified
     *
     * @param UserRoleUpdateRequest $request
     * @param \App\User $user
     * @return UserResource
     * @throws ValidationException
     */
    public function updateRole(UserRoleUpdateRequest $request, User $user)
    {
        $data = $request->only(['role']);
        if ($user->hasRole('admin')) {
            throw new UnauthorizedException('You cannot change the role of an admin.');
        }
        if ($user->galleryId != $request->user()->galleryId) {
            throw new UnauthorizedException('That member doesn\'t work in your gallery.');
        }
        $user->assignRole($data['role']);
        $user->role = $data['role'];
        $user->save();

        return new UserResource($user->refresh());
    }

    /**
     * @group Users
     *
     * @queryParam user User the user to be modified
     * @queryParam permission Permission the permissions to be applied
     *
    **/
    public function updatePermission(Request $request, User $user, Permission $permission)
    {
        if ($user->hasRole('admin')) {
            throw new UnauthorizedException('You cannot change the role of an admin.');
        }
        if ($user->galleryId != $request->user()->galleryId) {
            throw new UnauthorizedException('That member doesn\'t work in your gallery.');
        }

        if ($user->hasPermissionTo($permission)) {
            $user->revokePermissionTo($permission);
        } else {
            $user->givePermissionTo($permission);
        }
        $user->save();
        return PermissionResource::collection(request()->user()->getAllPermissions());
    }

    /**
     * Update the specified user in storage.
     *
     * @group Users
     *
     * @bodyParam firstname string the user's first name
     * @bodyParam last_name string the user's last name
     * @bodyParam name string the user's nickname
     * @bodyParam email string the user's email
     * @bodyParam password string the user's encrypted password
     * @bodyParam role string the user's role

     * @param UserUpdateRequest $request
     * @return UserResource
     * @throws ValidationException
     */
    public function update(UserUpdateRequest $request)
    {
        $user = $request->user();
        $data = $request->only(['firstname', 'lastname', 'name', 'email', 'role', 'password']);


        if (isset($data['firstname'])) {
            $user->firstname = $data['firstname'];
        }

        if (isset($data['lastname'])) {
            $user->lastname = $data['lastname'];
        }

        if (isset($data['name'])) {
            $user->name = $data['name'];
        }

        if (isset($data['email'])) {
            $user->email = $data['email'];
        }

        if (isset($data['role'])) {
            $user->role = $data['role'];
        }

        if (isset($data['password'])) {
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return new UserResource($user->refresh());
    }

    /**
     * Remove the specified user from storage.
     *
     * @group Users
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $user = request()->user();

        $user->delete();

        return response()->json(['message' => 'User deleted.'], 200);
    }
}
