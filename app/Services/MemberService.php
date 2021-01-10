<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MemberRepository;

class MemberService
{
    /**
     * @var \App\Repositories\MemberRepository $memberRepository
     */
    protected $memberReposity;

    /**
     * Member service constructor
     *
     * @param \App\Repositories\MemberRepository $memberReposity
     */
    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * Validate basic arguments ex.currentNumber
     *
     * @param array $args
     * @return void
     */
    protected function validateBasicArgument($args)
    {
        $validator = Validator::make($args, [
            'currentNumber' => 'required|integer|min:0',
            'requiredNumber' => 'required|integer|min:0|max:50'
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException(serialize($validator->errors()), 400);
        }
    }

    // protected function filterNull($data, $value)
    // {
    //     $data = $data->map(function ($item, $key) use ($value) {
    //         $item->numberofratings = $item->numberofratings == NULL ? $value : (double)$item->numberofratings;
    //         $item->averageofratings = $item->averageofratings == NULL ? $value : (double)$item->averageofratings;
    //         return $item;
    //     });

    //     return $data;
    // }

    public function getMembers($numbers)
    {
        $this->validateBasicArgument($numbers);

        $currentNumber = (int)$numbers['currentNumber'];
        $requiredNumber = (int)$numbers['requiredNumber'];

        $result = $this->memberRepository
            ->getMembers($currentNumber, $requiredNumber);

        return $result;
    }

    public function updateMember($payload)
    {
        $this->memberRepository->updateMember($payload);
    }

    public function deleteMember($id)
    {
        $this->memberRepository->deleteMember($id);
    }

    public function addMember($payload)
    {
        if($payload['member']['permission'] == 2)
        {
            $this->memberRepository->addCustomer($payload);
        }

        if($payload['member']['permission'] == 1)
        {
            if (!empty($payload['seller']['header_image']))
            {
                $image = $payload['seller']['header_image'];
                unset($payload['seller']['header_image']);
                $image_extension = $image->getClientOriginalExtension();
            }
            $seller_id = $this->memberRepository->addSeller($payload, $image_extension);
            if (!empty($payload['seller']['header_image']))    {$image->storeAs('public/restaurant/' . strval($seller_id), 'header' . '.' . $image_extension);}
        }
    }
}
?>
